<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // instansi pemilik menu ini
            $table->enum('audience', ['pemohon', 'pegawai', 'both'])
                ->default('both');

            // Self-reference buat submenu. Null = ini item di menu utama.
            $table->foreignId('parent_id')->nullable()
                ->constrained('menu_items')->cascadeOnDelete();

            $table->string('trigger'); // angka/kata kunci yang diketik user, misal "1" atau "cek"
            $table->string('label'); // teks yang ditampilin di daftar menu, misal "Cek Status Permohonan"

            // Kotak-kotak aksi yang tersedia. Base set (cek_status, riwayat_tahapan, exit)
            // kebuka di semua tier yang punya feature 'menu_builder'. pesan_custom & submenu
            // baru kebuka kalau tier-nya punya feature 'menu_action_pesan_custom' /
            // 'menu_action_submenu' masing-masing -- dicek di level Controller/FormRequest,
            // bukan di DB (biar gampang nambah action_type baru tanpa migration lagi).
            $table->string('action_type'); // cek_status | riwayat_tahapan | pesan_custom | submenu | exit

            // Parameter spesifik per action_type. Contoh utk pesan_custom: {"pesan": "..."}
            // Kosong/null wajar buat action_type yang gak butuh parameter (cek_status, exit).
            $table->json('action_config')->nullable();

            $table->unsignedInteger('sort_order')->default(0); // urutan tampil di dalam parent yang sama
            $table->boolean('is_active')->default(true); // biar admin bisa nonaktifin sementara tanpa hapus
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            // 1 trigger cuma boleh dipakai sekali per (user, parent) -- gak boleh dobel "1"
            // di menu utama yang sama, tapi boleh sama kalau beda submenu.
            $table->unique(['user_id', 'parent_id', 'trigger']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};