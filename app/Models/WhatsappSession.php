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
    private const ENTRY_KEYWORDS = ['menu', 'hai', 'halo', 'hi', 'start'];
    private const STATE_TIMEOUT_MINUTES = 10;

    public function __construct(private FonnteService $fonnte)
    {
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

            'antrian_pegawai' => $this->handleAntrianPegawai($user, $session, $sender, $item, $role),

            'info_pegawai' => $this->handleInfoPegawai($user, $session, $sender, $item, $role),

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

    /**
     * Identitas pegawai udah otomatis kedeteksi dari nomor WA-nya (cocok di
     * tabel Pegawai) -- gak perlu validasi no. permohonan/HP kayak cek_status,
     * langsung eksekusi & balik ke menu yang sama.
     */
    private function handleInfoPegawai(User $user, WhatsappSession $session, string $sender, MenuItem $item, string $role): void
    {
        $pegawai = $this->findPegawai($user, $sender);

        if (! $pegawai) {
            $this->reply($user, $sender, 'Menu ini khusus buat pegawai terdaftar.');
            $this->showMenu($user, $session, $sender, $item->parent_id, $role);
            return;
        }

        $template = data_get($item->action_config, 'template')
            ?: "Nama: {nama_pegawai}\nPosisi: {posisi_pegawai}\nNo. HP: {no_hp_pegawai}";

        $text = strtr($template, [
            '{nama_pegawai}' => $pegawai->nama ?? '-',
            '{posisi_pegawai}' => $pegawai->posisi ?? '-',
            '{no_hp_pegawai}' => $pegawai->no_hp ?? '-',
        ]);

        $this->reply($user, $sender, $text);
        $this->showMenu($user, $session, $sender, $item->parent_id, $role);
    }

    /**
     * Nampilin daftar permohonan yang nyangkut di posisi pegawai itu (tahapan
     * = posisi dia, status masih proses) -- tanpa perlu nanya apa-apa lagi,
     * soalnya posisinya udah ketauan dari data Pegawai yang cocok sama WA-nya.
     */
    private function handleAntrianPegawai(User $user, WhatsappSession $session, string $sender, MenuItem $item, string $role): void
    {
        $pegawai = $this->findPegawai($user, $sender);

        if (! $pegawai) {
            $this->reply($user, $sender, 'Menu ini khusus buat pegawai terdaftar.');
            $this->showMenu($user, $session, $sender, $item->parent_id, $role);
            return;
        }

        $antrian = Pemohon::where('user_id', $user->id)
            ->where('tahapan', $pegawai->posisi)
            ->where('status', 'proses')
            ->orderBy('created_at')
            ->get();

        $introTemplate = data_get($item->action_config, 'template')
            ?: "Antrian di posisi {posisi_pegawai} ({jumlah} permohonan):";

        $intro = strtr($introTemplate, [
            '{nama_pegawai}' => $pegawai->nama ?? '-',
            '{posisi_pegawai}' => $pegawai->posisi ?? '-',
            '{jumlah}' => (string) $antrian->count(),
        ]);

        if ($antrian->isEmpty()) {
            $this->reply($user, $sender, "{$intro}\n(Kosong, gak ada antrian saat ini.)");
        } else {
            $lines = $antrian->map(fn ($p) => "- {$p->no_permohonan} | {$p->nama}")->implode("\n");
            $this->reply($user, $sender, "{$intro}\n{$lines}");
        }

        $this->showMenu($user, $session, $sender, $item->parent_id, $role);
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

        $hpDigits = preg_replace('/\D/', '', (string) $pemohon->nomor_hp);
        if (strlen($hpDigits) < 4) {
            // Data nomor HP di permohonan ini gak lengkap/gak valid (misal cuma "0"),
            // gak akan pernah bisa dicocokin -- daripada muter-muter minta input yang
            // gak mungkin match, langsung kasih tau aja.
            $session->update([
                'current_state' => 'menu',
                'current_menu_id' => $context['return_menu_id'] ?? null,
                'context_data' => null,
                'state_expires_at' => null,
            ]);
            $this->reply($user, $sender, 'Data nomor HP untuk permohonan ini belum lengkap di sistem kami, jadi gak bisa diverifikasi otomatis. Silakan hubungi admin instansi buat cek manual.');
            $this->showMenu($user, $session, $sender, $context['return_menu_id'] ?? null, $this->detectRole($user, $sender));
            return;
        }

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

        $last4Terdaftar = substr((string) $pemohon->nomor_hp, -4);
        $valid = ctype_digit($messageTrim) && strlen($messageTrim) === 4 && hash_equals($last4Terdaftar, $messageTrim);

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
        $footer = $user->menu_footer_text ?: '(ketik "keluar" kapan aja buat berhenti)';

        $this->reply(
            $user,
            $sender,
            "{$header}{$intro}\n{$lines}\n\n{$footer}"
        );
    }

    private function findPegawai(User $user, string $normalizedSender): ?Pegawai
    {
        return Pegawai::where('user_id', $user->id)
            ->get()
            ->first(fn ($p) => $this->normalizePhone((string) $p->no_hp) === $normalizedSender);
    }

    private function detectRole(User $user, string $normalizedSender): string
    {
        return $this->findPegawai($user, $normalizedSender) ? 'pegawai' : 'pemohon';
    }

    /**
     * Normalisasi nomor ke format 62xxxxxxxxxx biar matching gak meleset gara-gara
     * beda format (08xx / +628xx / 628xx / ada spasi-strip).
     */
    private function normalizePhone(string $number): string
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