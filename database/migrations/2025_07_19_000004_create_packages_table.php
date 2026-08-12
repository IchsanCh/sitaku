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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tier_id')
                ->nullable() // nullable dulu biar package lama yg belum diisi ga error
                ->constrained()
                ->nullOnDelete(); // tier dihapus -> package ga ikut hilang, cuma lepas tier-nya
            $table->string('name'); // Basic / Premium / dll
            $table->text('description')->nullable(); // Boleh kosong
            $table->integer('price'); // dalam rupiah (misal 100000)
            $table->integer('duration_days'); // berapa lama aktifnya (misal 30 hari)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};