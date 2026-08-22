<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_chat_id')->constrained()->cascadeOnDelete();
            $table->enum('sender_type', ['pemohon', 'admin_support']);
            $table->foreignId('admin_support_id')->nullable()
                ->constrained('admin_supports')->nullOnDelete();
            $table->text('message');

            // ID pesan dari Fonnte (kalau payload webhook-nya nyertain) -- buat
            // cegah pesan kesimpen dobel kalau Fonnte retry kirim webhook yang sama.
            // Nullable karena kita belum yakin 100% field ini selalu ada di payload
            // asli mereka (lihat catatan di FonnteWebhookController).
            $table->string('fonnte_message_id')->nullable()->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_chat_messages');
    }
};