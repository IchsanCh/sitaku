<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // instansi (device Fonnte mana)
            $table->string('nomor_wa', 30); // nomor eksternal yang lagi chat (pemohon/pegawai)

            // idle | menu | awaiting_no_permohonan | awaiting_phone_validation
            $table->string('current_state')->default('idle');

            // Lagi di level menu mana (null = menu utama). Dipakai kalau current_state = 'menu'.
            $table->foreignId('current_menu_id')->nullable()
                ->constrained('menu_items')->nullOnDelete();

            // Data sementara buat alur multi-step (misal: intent cek_status/riwayat_tahapan,
            // pemohon_id yang lagi divalidasi, dll). Dibuang tiap kali balik ke idle/menu.
            $table->json('context_data')->nullable();

            // Timeout buat state yang nunggu input spesifik (awaiting_*). Kalau lewat,
            // otomatis direset ke idle pas ada pesan masuk berikutnya.
            $table->dateTime('state_expires_at')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'nomor_wa']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_sessions');
    }
};