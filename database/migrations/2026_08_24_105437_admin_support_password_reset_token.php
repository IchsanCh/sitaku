<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel terpisah dari `password_reset_tokens` yang dipakai users/admins --
        // itu dikunci per-email doang tanpa penanda guard, jadi kalau dipakai bareng
        // buat admin_support juga, email yang sama tapi beda akun (misal instansi
        // makein email yang sama buat akun admin_support-nya) bisa tabrakan token.
        Schema::create('admin_support_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_support_password_reset_tokens');
    }
};