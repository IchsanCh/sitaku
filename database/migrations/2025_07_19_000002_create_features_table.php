<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Max Pegawai / Akses API / Custom Pesan
            $table->string('slug')->unique(); // max_pegawai / api_access / custom_pesan — dipakai buat cek kode di app
            $table->enum('type', ['toggle', 'limit'])->default('toggle');
            // toggle = fitur nyala/mati, limit = fitur berbentuk kuota angka
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};