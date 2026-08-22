<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // instansi
            $table->string('nomor_wa', 30);
            $table->enum('status', ['open', 'closed'])->default('open');

            // Indikator lembut "lagi dibales sama siapa" -- BUKAN lock beneran
            // (admin lain tetep bisa bales), cuma ditampilin di UI biar admin
            // lain gak dobel jawab pertanyaan yang sama. Basi otomatis kalau
            // replying_at udah lewat beberapa menit (dicek di kode, bukan di DB).
            $table->foreignId('replying_admin_id')->nullable()
                ->constrained('admin_supports')->nullOnDelete();
            $table->timestamp('replying_at')->nullable();

            $table->timestamp('last_message_at')->nullable();
            $table->unsignedInteger('unread_count')->default(0);

            $table->timestamps();

            $table->unique(['user_id', 'nomor_wa']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_chats');
    }
};