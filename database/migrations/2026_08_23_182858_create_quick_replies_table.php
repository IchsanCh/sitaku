<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quick_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // instansi pemilik

            // Kata kunci yang diketik admin support di kotak chat, diawali "/" --
            // misal trigger "alur-pelayanan" dipanggil admin dengan ngetik "/alur-pelayanan".
            // Unik per instansi (bukan global) -- instansi lain boleh punya trigger yang sama.
            $table->string('trigger');
            $table->text('content'); // teks lengkap yang bakal ngisi kotak chat begitu dipilih

            $table->timestamps();

            $table->unique(['user_id', 'trigger']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quick_replies');
    }
};