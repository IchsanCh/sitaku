<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Models\Pegawai;
use App\Models\Pemohon;
use App\Models\Pesan;
use App\Models\User;
use App\Models\WhatsappSession;
use Illuminate\Support\Carbon;

class WhatsappStateMachineService
{
    private const EXIT_KEYWORDS = ['exit', 'keluar', 'selesai', 'batal'];
    private const BACK_KEYWORDS = ['back', 'kembali', 'balik'];
    private const ENTRY_KEYWORDS = ['menu', 'hai', 'halo', 'hi', 'start'];
    private const STATE_TIMEOUT_MINUTES = 10;

    public function __construct(private FonnteService $fonnte, private LiveChatService $liveChat)
    {
    }

    /**
     * Dipakai bareng sama FonnteWebhookController -- pas session lagi di state
     * 'live_support', webhook gak lewat handle() di sini sama sekali (langsung
     * ke LiveChatService), tapi tetep butuh cek exit keyword yang SAMA biar
     * pemohon bisa keluar dari live chat pakai kata kunci yang konsisten.
     */
    public function isExitCommand(string $message): bool
    {
        return in_array(strtolower(trim($message)), self::EXIT_KEYWORDS, true);
    }

    public function handle(User $user, string $rawSender, string $message): void
    {
        $sender = $this->normalizePhone($rawSender);
        $role = $this->detectRole($user, $sender);

        // Master switch per audience -- dicek PALING duluan, sebelum exit/session
        // apapun disentuh. Kalau nonaktif buat role ini, bot diem total, gak ada
        // balasan apapun, gak ada session yang dibuat/diubah.
        $enabled = $role === 'pegawai'
            ? $user->state_machine_pegawai === 'aktif'
            : $user->state_machine_pemohon === 'aktif';

        if (! $enabled) {
            return;
        }

        $messageTrim = trim($message);
        $messageLower = strtolower($messageTrim);

        $session = WhatsappSession::firstOrCreate(
            ['user_id' => $user->id, 'nomor_wa' => $sender],
            ['current_state' => 'idle']
        );

        // Timeout: state yang lagi nunggu input spesifik kelewat waktu -> anggap basi, reset dulu.
        if ($session->isExpired()) {
            $session->resetToIdle();
        }

        // Exit dicek PALING ATAS, berlaku di state manapun -- gak peduli lagi di tengah
        // alur apa, user selalu bisa keluar bersih.
        if (in_array($messageLower, self::EXIT_KEYWORDS, true)) {
            $session->resetToIdle();
            $this->reply($user, $sender, 'Baik, sesi diakhiri. Ketik "menu" kapan aja buat mulai lagi.');
            return;
        }

        match ($session->current_state) {
            'idle' => $this->handleIdle($user, $session, $sender, $messageLower, $role),
            'menu' => $this->handleMenu($user, $session, $sender, $messageTrim, $role),
            'awaiting_no_permohonan' => $this->handleAwaitingNoPermohonan($user, $session, $sender, $messageTrim),
            'awaiting_phone_validation' => $this->handleAwaitingPhoneValidation($user, $session, $sender, $messageTrim),
            default => $session->resetToIdle(),
        };
    }

    private function handleIdle(User $user, WhatsappSession $session, string $sender, string $messageLower, string $role): void
    {
        // Diem total kalau bukan trigger keyword -- biar gak nyerempet obrolan manual admin.
        if (! in_array($messageLower, self::ENTRY_KEYWORDS, true)) {
            return;
        }

        $this->showMenu($user, $session, $sender, null, $role);
    }

    private function handleMenu(User $user, WhatsappSession $session, string $sender, string $messageTrim, string $role): void
    {
        $messageLower = strtolower($messageTrim);

        if (in_array($messageLower, self::BACK_KEYWORDS, true)) {
            if ($session->current_menu_id === null) {
                // Udah di menu paling atas, gak ada tempat buat naik lagi --
                // tampilin ulang aja menu utamanya.
                $this->showMenu($user, $session, $sender, null, $role);
                return;
            }

            $currentContainer = MenuItem::find($session->current_menu_id);
            $this->showMenu($user, $session, $sender, $currentContainer?->parent_id, $role);
            return;
        }

        $item = MenuItem::where('user_id', $user->id)
            ->where('parent_id', $session->current_menu_id)
            ->where('is_active', true)
            ->whereIn('audience', [$role, 'both'])
            ->where('trigger', $messageTrim)
            ->first();

        if (! $item) {
            $this->reply($user, $sender, 'Pilihan tidak dikenali. Ketik salah satu nomor/kata di menu, atau "keluar" buat berhenti.');
            return;
        }

        $this->executeAction($user, $session, $sender, $item, $role);
    }

    private function executeAction(User $user, WhatsappSession $session, string $sender, MenuItem $item, string $role): void
    {
        match ($item->action_type) {
            'exit' => (function () use ($session, $user, $sender) {
                $session->resetToIdle();
                $this->reply($user, $sender, 'Baik, sesi diakhiri. Ketik "menu" kapan aja buat mulai lagi.');
            })(),

            'submenu' => (function () use ($user, $session, $sender, $item, $role) {
                $this->showMenu($user, $session, $sender, $item->id, $role, prefixLabel: $item->label);
            })(),

            'pesan_custom' => (function () use ($user, $session, $sender, $item, $role) {
                $pesan = data_get($item->action_config, 'template', data_get($item->action_config, 'pesan', ''));
                if ($pesan !== '') {
                    $this->reply($user, $sender, $pesan);
                }
                // Tetep di level menu yang sama, tampilin ulang biar bisa pilih lagi.
                $this->showMenu($user, $session, $sender, $item->parent_id, $role);
            })(),

            'cek_status', 'riwayat_tahapan' => $this->startValidationFlow($user, $session, $sender, $item),

            'live_support' => (function () use ($user, $session, $sender) {
                $this->liveChat->openRoom($user, $sender);
                $session->update([
                    'current_state' => 'live_support',
                    'current_menu_id' => null,
                    'context_data' => null,
                    'state_expires_at' => null,
                ]);
                $this->reply($user, $sender, 'Anda akan terhubung dengan admin kami. Silakan sampaikan pertanyaan Anda, admin akan membalas sesegera mungkin. (ketik "keluar" kapan aja buat mengakhiri sesi ini)');
            })(),

            default => $this->reply($user, $sender, 'Aksi menu ini belum didukung.'),
        };
    }

    private function startValidationFlow(User $user, WhatsappSession $session, string $sender, MenuItem $item): void
    {
        $session->update([
            'current_state' => 'awaiting_no_permohonan',
            'context_data' => [
                'intent' => $item->action_type,
                'menu_item_id' => $item->id,
                'return_menu_id' => $item->parent_id,
            ],
            'state_expires_at' => now()->addMinutes(self::STATE_TIMEOUT_MINUTES),
        ]);

        $this->reply($user, $sender, 'Masukkan Nomor Permohonan Anda:');
    }

    private function handleAwaitingNoPermohonan(User $user, WhatsappSession $session, string $sender, string $messageTrim): void
    {
        $pemohon = Pemohon::where('user_id', $user->id)
            ->where('no_permohonan', $messageTrim)
            ->first();

        if (! $pemohon) {
            $this->reply($user, $sender, 'Nomor permohonan tidak ditemukan. Coba masukkan ulang, atau ketik "keluar" buat berhenti.');
            // State tetep sama, biar user bisa coba lagi -- perpanjang timeout-nya.
            $session->update(['state_expires_at' => now()->addMinutes(self::STATE_TIMEOUT_MINUTES)]);
            return;
        }

        $context = $session->context_data ?? [];
        $context['pemohon_id'] = $pemohon->id;

        $session->update([
            'current_state' => 'awaiting_phone_validation',
            'context_data' => $context,
            'state_expires_at' => now()->addMinutes(self::STATE_TIMEOUT_MINUTES),
        ]);

        $this->reply($user, $sender, 'Untuk validasi, masukkan 4 digit terakhir nomor HP yang terdaftar pada permohonan ini:');
    }

    private function handleAwaitingPhoneValidation(User $user, WhatsappSession $session, string $sender, string $messageTrim): void
    {
        $context = $session->context_data ?? [];
        $pemohon = Pemohon::find(data_get($context, 'pemohon_id'));

        if (! $pemohon) {
            // Data hilang/gak konsisten -- reset aja daripada nyangkut.
            $session->resetToIdle();
            $this->reply($user, $sender, 'Terjadi kesalahan, sesi direset. Ketik "menu" buat mulai lagi.');
            return;
        }

        // Ambil sampe 4 digit terakhir dari yang KESIMPEN -- kalau nomor HP-nya
        // di database emang cuma pendek/aneh (misal "0"), tetep dicocokin apa
        // adanya, bukan dipaksa selalu 4 digit.
        $hpDigitsTerdaftar = preg_replace('/\D/', '', (string) $pemohon->nomor_hp);
        $tailTerdaftar = substr($hpDigitsTerdaftar, -4);
        $inputDigits = preg_replace('/\D/', '', $messageTrim);

        $valid = $tailTerdaftar !== '' && hash_equals($tailTerdaftar, $inputDigits);

        if (! $valid) {
            $this->reply($user, $sender, '4 digit tidak cocok. Coba lagi, atau ketik "keluar" buat berhenti.');
            $session->update(['state_expires_at' => now()->addMinutes(self::STATE_TIMEOUT_MINUTES)]);
            return;
        }

        $intent = data_get($context, 'intent', 'cek_status');
        $menuItem = MenuItem::find(data_get($context, 'menu_item_id'));
        $template = data_get($menuItem?->action_config, 'template');

        $this->reply($user, $sender, $this->buildValidationResultMessage($pemohon, $intent, $template));

        // Selesai -- balik ke menu level asal (tempat menu item cek_status/riwayat_tahapan tadi dipencet).
        $returnMenuId = data_get($context, 'return_menu_id');
        $role = $this->detectRole($user, $sender);
        $session->update([
            'current_state' => 'menu',
            'current_menu_id' => $returnMenuId,
            'context_data' => null,
            'state_expires_at' => null,
        ]);
        $this->showMenu($user, $session, $sender, $returnMenuId, $role);
    }

    private function buildValidationResultMessage(Pemohon $pemohon, string $intent, ?string $template = null): string
    {
        if ($intent === 'riwayat_tahapan') {
            $riwayat = Pesan::where('pemohon_id', $pemohon->id)
                ->orderBy('created_at')
                ->get();

            if ($riwayat->isEmpty()) {
                return "Belum ada riwayat notifikasi untuk permohonan {$pemohon->no_permohonan}.";
            }

            // Template di sini cuma buat baris PEMBUKA -- format tiap baris riwayat
            // tetap baku, soalnya itu daftar (bukan satu pesan tunggal kayak cek_status).
            $intro = filled($template)
                ? $this->renderTemplate($template, $pemohon)
                : "Riwayat notifikasi permohonan {$pemohon->no_permohonan}:";

            $lines = $riwayat->map(function ($pesan) {
                $tgl = Carbon::parse($pesan->created_at)->format('d M Y H:i');
                return "- {$tgl}: " . \Illuminate\Support\Str::limit(strip_tags($pesan->pesan), 80);
            })->implode("\n");

            return "{$intro}\n{$lines}";
        }

        // default: cek_status
        if (filled($template)) {
            return $this->renderTemplate($template, $pemohon);
        }

        return "Status permohonan {$pemohon->no_permohonan}:\n"
            . "Tahapan: {$pemohon->tahapan}\n"
            . "Status: {$pemohon->status}";
    }

    /**
     * Ganti placeholder {nama}, {no_permohonan}, dst di template custom user
     * dengan data pemohon yang beneran ketemu. Pola sama kayak
     * pesan_pemohon/pesan_penyerahan yang udah ada di aplikasi ini.
     */
    private function renderTemplate(string $template, Pemohon $pemohon): string
    {
        return strtr($template, [
            '{nama}' => $pemohon->nama ?? '-',
            '{no_permohonan}' => $pemohon->no_permohonan ?? '-',
            '{nama_izin}' => $pemohon->nama_izin ?? '-',
            '{tahapan}' => $pemohon->tahapan ?? '-',
            '{status}' => $pemohon->status ?? '-',
            '{link_izin}' => $pemohon->link_izin ?? '-',
            '{no_hp}' => $pemohon->nomor_hp ?? '-',
        ]);
    }

    private function showMenu(User $user, WhatsappSession $session, string $sender, ?int $parentId, string $role, ?string $prefixLabel = null): void
    {
        $items = MenuItem::where('user_id', $user->id)
            ->where('parent_id', $parentId)
            ->where('is_active', true)
            ->whereIn('audience', [$role, 'both'])
            ->orderBy('sort_order')
            ->get();

        if ($items->isEmpty()) {
            $session->resetToIdle();
            $this->reply($user, $sender, 'Menu belum tersedia untuk saat ini. Silakan hubungi admin instansi.');
            return;
        }

        // Selalu sinkronin state session ke level menu ini -- baik pas masuk dari
        // idle, masuk submenu, maupun nampilin ulang abis suatu aksi selesai.
        // Ini dulu kelewat pas jalur "masuk dari idle", makanya trigger abis itu
        // ke-anggep gak dikenali (session-nya nyangkut di 'idle').
        $session->update(['current_state' => 'menu', 'current_menu_id' => $parentId]);

        $lines = $items->map(fn ($i) => "{$i->trigger}. {$i->label}")->implode("\n");
        $header = $prefixLabel ? "{$prefixLabel}\n" : '';

        $intro = $user->menu_intro_text ?: 'Silakan pilih:';
        $defaultFooter = '(ketik "keluar" kapan aja buat berhenti'
            . ($parentId !== null ? ', atau "kembali" buat naik satu level' : '')
            . ')';
        $footer = $user->menu_footer_text ?: $defaultFooter;

        $this->reply(
            $user,
            $sender,
            "{$header}{$intro}\n{$lines}\n\n{$footer}"
        );
    }

    private function detectRole(User $user, string $normalizedSender): string
    {
        $isPegawai = Pegawai::where('user_id', $user->id)
            ->get()
            ->contains(fn ($p) => $this->normalizePhone((string) $p->no_hp) === $normalizedSender);

        return $isPegawai ? 'pegawai' : 'pemohon';
    }

    /**
     * Normalisasi nomor ke format 62xxxxxxxxxx biar matching gak meleset gara-gara
     * beda format (08xx / +628xx / 628xx / ada spasi-strip).
     */
    public function normalizePhone(string $number): string
    {
        $digits = preg_replace('/\D/', '', $number);

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        return $digits;
    }

    private function reply(User $user, string $target, string $message): void
    {
        $this->fonnte->send($user, $target, $message);
    }
}