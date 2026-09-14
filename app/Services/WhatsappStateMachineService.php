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

    /**
     * Dicek LIVE tiap kali dipanggil (bukan disimpen sebagai flag) -- biar
     * begitu instansi upgrade/downgrade/expired, hasilnya otomatis ikut
     * berubah tanpa perlu sinkronin apa-apa. Base actions selalu true.
     */
    private function isActionStillAllowed(User $user, MenuItem $item): bool
    {
        $requiredFeature = MenuItem::PREMIUM_ACTIONS[$item->action_type] ?? null;

        return $requiredFeature === null || $user->hasFeature($requiredFeature);
    }

    /**
     * Dipakai FonnteWebhookController buat cek ulang eligibility live_support
     * SEBELUM neruskan pesan masuk ke LiveChatService -- baik gara-gara
     * downgrade paket maupun subscription expired.
     */
    public function isLiveSupportEligible(User $user): bool
    {
        return $user->hasActiveSubscription() && $user->hasFeature('menu_action_live_support');
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
        // Jaga-jaga -- harusnya udah ke-filter duluan di showMenu(), tapi kalau
        // trigger-nya sempet keketik user pas downgrade/expired lagi kejadian
        // tepat di tengah-tengah, tetep ke-block di sini.
        if (! $this->isActionStillAllowed($user, $item)) {
            $this->reply($user, $sender, 'Menu ini udah gak tersedia buat instansi ini. Ketik "menu" buat lihat pilihan yang ada.');
            $session->resetToIdle();
            return;
        }

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
                    $pegawai = $role === 'pegawai' ? $this->findPegawai($user, $sender) : null;
                    $pesan = $this->renderCustomTemplate($pesan, $user, $pegawai);
                    $this->reply($user, $sender, $pesan);
                }
                // Tetep di level menu yang sama, tampilin ulang biar bisa pilih lagi.
                $this->showMenu($user, $session, $sender, $item->parent_id, $role);
            })(),

            'cek_status', 'riwayat_tahapan' => $this->startValidationFlow($user, $session, $sender, $item),

            'antrian_pegawai' => (function () use ($user, $session, $sender, $item, $role) {
                $pegawai = $this->findPegawai($user, $sender);
                $template = data_get($item->action_config, 'template');
                $rowTemplate = data_get($item->action_config, 'row_template');
                $this->reply($user, $sender, $this->buildAntrianPegawaiMessage($user, $pegawai, $template, $rowTemplate));
                $this->showMenu($user, $session, $sender, $item->parent_id, $role);
            })(),

            'info_pegawai' => (function () use ($user, $session, $sender, $item, $role) {
                $pegawai = $this->findPegawai($user, $sender);
                $template = data_get($item->action_config, 'template');
                $this->reply($user, $sender, $this->buildInfoPegawaiMessage($pegawai, $template, $user));
                $this->showMenu($user, $session, $sender, $item->parent_id, $role);
            })(),

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

        $this->reply($user, $sender, $this->buildValidationResultMessage($pemohon, $intent, $user, $template));

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

    private function buildValidationResultMessage(Pemohon $pemohon, string $intent, User $user, ?string $template = null): string
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
                ? $this->renderTemplate($template, $pemohon, $user)
                : "Riwayat notifikasi permohonan {$pemohon->no_permohonan}:";

            $lines = $riwayat->map(function ($pesan) {
                $tgl = Carbon::parse($pesan->created_at)->format('d M Y H:i');
                return "- {$tgl}: " . \Illuminate\Support\Str::limit(strip_tags($pesan->pesan), 80);
            })->implode("\n");

            return "{$intro}\n{$lines}";
        }

        // default: cek_status
        if (filled($template)) {
            return $this->renderTemplate($template, $pemohon, $user);
        }

        return "Status permohonan {$pemohon->no_permohonan}:\n"
            . "Tahapan: {$pemohon->tahapan}\n"
            . "Status: {$pemohon->status}";
    }

    /**
     * Variabel UMUM -- selalu tersedia di semua template, gak butuh konteks
     * pemohon/pegawai apa pun. Satu-satunya tempat buat nambah variabel jenis
     * ini; begitu ditambah di sini, otomatis kepake di semua template yang
     * manggil generalVariables().
     */
    private function generalVariables(User $user): array
    {
        return [
            '{username}' => $user->name ?? '-',
            '{tanggal}' => Carbon::now()->translatedFormat('d M Y'),
            '{jam}' => Carbon::now()->format('H:i'),
        ];
    }

    /**
     * Variabel data PEMOHON -- satu-satunya tempat buat nambah field pemohon
     * baru (cek_status, riwayat_tahapan, dan baris antrian_pegawai semua
     * manggil ini, jadi otomatis konsisten di ketiganya).
     */
    private function pemohonVariables(Pemohon $pemohon): array
    {
        return [
            '{nama}' => $pemohon->nama ?? '-',
            '{no_permohonan}' => $pemohon->no_permohonan ?? '-',
            '{nama_izin}' => $pemohon->nama_izin ?? '-',
            '{tahapan}' => $pemohon->tahapan ?? '-',
            '{status}' => $pemohon->status ?? '-',
            '{link_izin}' => $pemohon->link_izin ?? '-',
            '{no_hp}' => $pemohon->nomor_hp ?? '-',
            '{tgl_pengajuan}' => $pemohon->tgl_pengajuan ? Carbon::parse($pemohon->tgl_pengajuan)->translatedFormat('d M Y') : '-',
        ];
    }

    /**
     * Variabel data PEGAWAI -- satu-satunya tempat buat nambah field pegawai
     * baru. $pegawai nullable karena kadang dipanggil dari konteks yang belum
     * pasti pegawai-nya ketemu (mis. pesan_custom yang diakses pemohon) --
     * placeholder-nya jadi '-' daripada dibiarin mentah di pesan.
     */
    private function pegawaiVariables(?Pegawai $pegawai): array
    {
        return [
            '{nama_pegawai}' => $pegawai?->nama ?? '-',
            '{posisi_pegawai}' => $pegawai?->posisi ?? '-',
            '{no_hp_pegawai}' => $pegawai?->no_hp ?? '-',
        ];
    }

    /**
     * Ganti placeholder {nama}, {no_permohonan}, dst di template custom user
     * dengan data pemohon yang beneran ketemu, plus variabel umum ({username},
     * {tanggal}, {jam}). Pola sama kayak pesan_pemohon/pesan_penyerahan yang
     * udah ada di aplikasi ini.
     */
    private function renderTemplate(string $template, Pemohon $pemohon, User $user): string
    {
        return strtr($template, array_merge(
            $this->generalVariables($user),
            $this->pemohonVariables($pemohon),
        ));
    }

    private function showMenu(User $user, WhatsappSession $session, string $sender, ?int $parentId, string $role, ?string $prefixLabel = null): void
    {
        $items = MenuItem::where('user_id', $user->id)
            ->where('parent_id', $parentId)
            ->where('is_active', true)
            ->whereIn('audience', [$role, 'both'])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn (MenuItem $item) => $this->isActionStillAllowed($user, $item))
            ->values();

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
        return $this->findPegawai($user, $normalizedSender) ? 'pegawai' : 'pemohon';
    }

    /**
     * Cari record Pegawai yang no HP-nya cocok sama nomor pengirim (udah dinormalisasi).
     * Dipakai buat detectRole() (cuma butuh tau ada/nggaknya) dan juga action_type
     * yang butuh identitas pegawai beneran (antrian_pegawai, info_pegawai, pesan_custom).
     */
    private function findPegawai(User $user, string $normalizedSender): ?Pegawai
    {
        return Pegawai::where('user_id', $user->id)
            ->get()
            ->first(fn ($p) => $this->normalizePhone((string) $p->no_hp) === $normalizedSender);
    }

    /**
     * "Antrian saya": daftar permohonan yang tahapannya lagi di posisi pegawai ini
     * (tahapan pemohon dicocokin ke posisi pegawai, case-insensitive) DAN statusnya
     * masih "proses" -- kalau statusnya udah sudah/done/selesai/dll, dianggap
     * bukan bagian antrian lagi. Diurutin dari yang paling lama ngantri (tgl_pengajuan,
     * fallback ke created_at kalau kosong).
     */
    private function buildAntrianPegawaiMessage(User $user, ?Pegawai $pegawai, ?string $template, ?string $rowTemplate = null): string
    {
        if (! $pegawai) {
            return 'Data pegawai kamu gak ketemu di sistem. Hubungi admin instansi buat didaftarin dulu.';
        }

        $posisi = trim((string) $pegawai->posisi);

        $antrian = Pemohon::where('user_id', $user->id)
            ->whereRaw('LOWER(tahapan) = ?', [strtolower($posisi)])
            ->whereRaw('LOWER(status) = ?', ['proses'])
            ->orderByRaw('COALESCE(tgl_pengajuan, created_at) asc')
            ->get();

        $jumlah = $antrian->count();
        $vars = array_merge(
            $this->generalVariables($user),
            $this->pegawaiVariables($pegawai),
            ['{jumlah}' => (string) $jumlah],
        );

        $intro = filled($template)
            ? strtr($template, $vars)
            : "Antrian di posisi {$vars['{posisi_pegawai}']} ({$jumlah} permohonan):";

        if ($antrian->isEmpty()) {
            return "{$intro}\n(kosong, gak ada antrian saat ini)";
        }

        // Format per-baris bisa di-custom bebas (variabel sama kayak yang dipakai
        // di cek_status/riwayat_tahapan -- satu kosakata variabel buat semua
        // template pemohon, lewat pemohonVariables()) -- kosong = balik ke
        // format lama biar menu yang udah ada gak berubah tiba-tiba.
        $rowTemplate = filled($rowTemplate) ? $rowTemplate : '- {no_permohonan} | {nama}';

        $lines = $antrian->map(fn (Pemohon $p) => strtr($rowTemplate, $this->pemohonVariables($p)))->implode("\n");

        return "{$intro}\n{$lines}";
    }

    /**
     * "Info saya": identitas pegawai yang lagi chat, kedeteksi otomatis dari nomor WA-nya.
     */
    private function buildInfoPegawaiMessage(?Pegawai $pegawai, ?string $template, User $user): string
    {
        if (! $pegawai) {
            return 'Data pegawai kamu gak ketemu di sistem. Hubungi admin instansi buat didaftarin dulu.';
        }

        $vars = array_merge(
            $this->generalVariables($user),
            $this->pegawaiVariables($pegawai),
        );

        if (filled($template)) {
            return strtr($template, $vars);
        }

        return "Nama: {$vars['{nama_pegawai}']}\nPosisi: {$vars['{posisi_pegawai}']}\nNo. HP: {$vars['{no_hp_pegawai}']}";
    }

    /**
     * Render template pesan_custom: gabungan variable UMUM (selalu ada, gak butuh
     * konteks apa-apa) + variable PEGAWAI (cuma keisi kalau yang mencet menu ini
     * kedeteksi sebagai pegawai terdaftar -- kalau pemohon atau pegawai gak ketemu,
     * placeholder pegawai diisi '-' daripada dibiarin mentah di pesan).
     */
    private function renderCustomTemplate(string $template, User $user, ?Pegawai $pegawai): string
    {
        $vars = array_merge(
            $this->generalVariables($user),
            $this->pegawaiVariables($pegawai),
        );

        return strtr($template, $vars);
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