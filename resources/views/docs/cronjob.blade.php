@extends('user.layout3')

@section('title', 'Cronjob Time')

@section('meta_description',
    'Pelajari jadwal cronjob dan sinkronisasi otomatis pada sistem Sitaku. Dokumentasi ini
    menjelaskan waktu pengiriman pesan, sinkronisasi data, dan penghapusan otomatis.')

@section('og_description',
    'Dokumentasi lengkap jadwal cronjob Sitaku. Ketahui kapan sistem mengirim pesan otomatis,
    melakukan sinkronisasi data pegawai, dan menghapus log lama.')

@section('content')
    <div class="container mx-auto p-6 max-w-5xl">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold mb-2">Jadwal Cronjob & Sinkronisasi Data</h1>
            <p class="text-base-content/70 text-lg">Sistem otomatisasi dan penjadwalan untuk efisiensi maksimal</p>
        </div>

        <!-- Cards Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-2">
            <!-- Pengiriman Otomatis ke Pegawai -->
            <div
                class="card bg-base-100 shadow-xl border-0 ring-1 ring-base-300/30 hover:ring-primary/20 hover:shadow-2xl transition-all duration-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-primary/10 p-3 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </div>
                        <h2 class="card-title text-xl text-black">Pengiriman ke Pegawai</h2>
                    </div>

                    <div class="space-y-4 font-semibold">
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Pengiriman otomatis saat ada pemohon baru</span>
                        </div>

                        <div class="divider">Jadwal Harian</div>

                        <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                            <div class="badge badge-warning">07:00 WIB</div>
                            <span class="text-sm">Reset status pengiriman</span>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                            <div class="badge badge-success">07:00 WIB</div>
                            <span class="text-sm">Kirim pesan pengingat rutin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengiriman Otomatis Pemohon -->
            <div
                class="card bg-base-100 shadow-xl border-0 ring-1 ring-base-300/30 hover:ring-primary/20 hover:shadow-2xl transition-all duration-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-secondary/10 p-3 rounded-full">
                            <span class="text-2xl"><i class="fa-solid fa-paper-plane text-primary"></i></span>
                        </div>
                        <h2 class="card-title text-xl">Pengiriman ke Pemohon</h2>
                    </div>

                    <div class="space-y-4 font-semibold">
                        <div class="stat bg-base-300 rounded-lg">
                            <div class="stat-title text-black">Interval Pembaruan</div>
                            <div class="stat-value text-2xl text-secondary">15 Menit</div>
                            <div class="stat-desc text-black">Pembaruan data otomatis</div>
                        </div>

                        <div class="alert alert-success">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">Pesan dikirim hanya untuk data baru atau perubahan tahapan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sinkronisasi Data -->
            <div
                class="card bg-base-100 shadow-xl border-0 ring-1 ring-base-300/30 hover:ring-primary/20 hover:shadow-2xl transition-all duration-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-accent/10 p-3 rounded-full">
                            <span class="text-2xl"><i class="fa-solid fa-arrows-rotate text-primary"></i></span>
                        </div>
                        <h2 class="card-title text-xl">Sinkronisasi Data</h2>
                    </div>

                    <div class="space-y-4 font-semibold">
                        <div class="stat bg-base-300 rounded-lg">
                            <div class="stat-title text-black">Sinkronisasi API Pemohon</div>
                            <div class="stat-value text-2xl text-accent">15 Menit</div>
                            <div class="stat-desc text-black">Pembaruan dari endpoint API Pemohon</div>
                        </div>

                        <div class="alert alert-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                            <span class="text-sm">Pastikan endpoint API aktif dan valid</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penghapusan Otomatis -->
            <div
                class="card bg-base-100 shadow-xl border-0 ring-1 ring-base-300/30 hover:ring-primary/20 hover:shadow-2xl transition-all duration-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-error/10 p-3 rounded-full">
                            <span class="text-2xl"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6 text-primary">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </span>
                        </div>
                        <h2 class="card-title text-xl">Penghapusan Otomatis</h2>
                    </div>

                    <div class="space-y-4 font-semibold">
                        <div class="stat bg-base-300 rounded-lg">
                            <div class="stat-title text-black">Retensi Data</div>
                            <div class="stat-value text-2xl text-error">3 Bulan</div>
                            <div class="stat-desc text-black">Otomatis dihapus</div>
                        </div>

                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">Data pesan lama dihapus untuk menjaga performa sistem</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="mt-8">
            <div
                class="card bg-base-100 shadow-xl border-0 ring-1 ring-base-300/30 hover:ring-primary/20 hover:shadow-2xl transition-all duration-300">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-warning/10 p-3 rounded-full">
                            <span class="text-2xl"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </span>
                        </div>
                        <h2 class="card-title text-xl">Catatan Penting</h2>
                    </div>

                    <div class="alert alert-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                        <div class="flex items-center gap-2">
                            <span class="font-semibold">Zona Waktu: <span class="font-bold">WIB (UTC+7)</span></span>
                        </div>
                    </div>
                    <div class="alert alert-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                        <div class="flex items-center gap-2">
                            <span class="font-semibold">Data pemohon dihapus jika berusia lebih dari <span
                                    class="font-bold">6 Bulan</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
