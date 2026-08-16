@extends('user.layout2')

@section('title', 'Custom Menu WA')
@section('meta_description', 'Atur menu interaktif WhatsApp untuk pemohon dan pegawai.')
@section('og_description', 'Kelola custom menu WhatsApp SITAKU sesuai kebutuhan instansi Anda.')

@section('content')
<div class="min-h-screen bg-base-100 py-8">
    <div class="bg-base-100 borderbc1">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-base-content">
                        Custom Menu WA
                        @if ($parent)
                            <span class="text-lg font-normal text-base-content/60">/ {{ $parent->label }}</span>
                        @endif
                    </h1>
                    <p class="text-base-content/70">Atur menu interaktif yang dilihat pemohon & pegawai di WhatsApp</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 mt-6">

        @if (session('success'))
            <div class="alert alert-success mb-6">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error mb-6">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($parent)
            <a href="{{ route('menu.index', ['parent' => $parent->parent_id]) }}" class="btn btn-ghost btn-sm mb-4">
                ← Kembali ke {{ $parent->parent_id ? 'submenu sebelumnya' : 'menu utama' }}
            </a>
        @endif

        @if (empty($allowedActions))
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body text-center py-12">
                    <h2 class="text-xl font-bold">Fitur belum tersedia di paket Anda</h2>
                    <p class="text-base-content/60 mt-2">Upgrade paket untuk bisa mengatur custom menu WhatsApp.</p>
                    <a href="{{ route('user.billing') }}" class="btn btn-primary mt-4 mx-auto">Lihat Paket</a>
                </div>
            </div>
        @else
            <div class="flex justify-between items-center mb-4">
                <p class="text-sm text-base-content/60">
                    {{ $items->count() }} item di level ini. User WA ketik trigger buat pilih menu ini.
                </p>
                <a href="{{ route('menu.create', ['parent' => $parent?->id]) }}" class="btn btn-primary btn-sm">
                    + Tambah Menu Item
                </a>
            </div>

            @if ($items->isEmpty())
                <div class="card bg-base-100 shadow border border-base-300">
                    <div class="card-body text-center py-10 text-base-content/60">
                        Belum ada menu item di level ini. Klik "Tambah Menu Item" buat mulai.
                    </div>
                </div>
            @else
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Trigger</th>
                                    <th>Label</th>
                                    <th>Untuk</th>
                                    <th>Aksi</th>
                                    <th>Status</th>
                                    <th class="text-right">Kelola</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td><span class="badge badge-neutral">{{ $item->trigger }}</span></td>
                                        <td class="font-medium">{{ $item->label }}</td>
                                        <td>
                                            <span class="badge badge-sm {{ match($item->audience) { 'pemohon' => 'badge-info', 'pegawai' => 'badge-warning', default => 'badge-ghost' } }}">
                                                {{ match($item->audience) { 'pemohon' => 'Pemohon', 'pegawai' => 'Pegawai', default => 'Semua' } }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-outline">
                                                {{ match($item->action_type) {
                                                    'cek_status' => 'Cek Status',
                                                    'riwayat_tahapan' => 'Riwayat Tahapan',
                                                    'pesan_custom' => 'Pesan Custom',
                                                    'submenu' => 'Submenu',
                                                    'exit' => 'Exit',
                                                    default => $item->action_type,
                                                } }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($item->is_active)
                                                <span class="badge badge-success badge-sm">Aktif</span>
                                            @else
                                                <span class="badge badge-ghost badge-sm">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-right space-x-1">
                                            @if ($item->action_type === 'submenu')
                                                <a href="{{ route('menu.index', ['parent' => $item->id]) }}" class="btn btn-xs btn-outline">
                                                    Kelola Submenu
                                                </a>
                                            @endif
                                            <a href="{{ route('menu.edit', $item) }}" class="btn btn-xs btn-outline">Edit</a>
                                            <form action="{{ route('menu.destroy', $item) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Yakin hapus menu item ini? {{ $item->action_type === 'submenu' ? 'Semua submenu di dalamnya juga ikut kehapus.' : '' }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-error btn-outline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection