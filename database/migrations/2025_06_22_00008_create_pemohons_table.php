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
        Schema::create('pemohons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id')->index();
            $table->foreignId('user_id')->nullable()->constrained()->after('external_id');
            $table->string('nama')->nullable();
            $table->string('nomor_hp', 20)->nullable();
            $table->string('no_permohonan', 100)->nullable()->index();
            $table->string('nama_izin')->nullable();
            $table->string('tahapan')->nullable()->index();
            $table->string('status', 100)->nullable()->index();
            $table->enum('kirim_pegawai', ['sudah', 'belum'])->index();
            $table->char('payload_hash', 32)->nullable()->unique();
            $table->dateTime('tgl_pengajuan')->nullable();
            $table->string('last_notified_tahapan')->nullable()->index();
            $table->dateTime('notified_at')->nullable()->index();
            $table->timestamps();
            $table->index(['user_id', 'external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemohons');
    }
};
