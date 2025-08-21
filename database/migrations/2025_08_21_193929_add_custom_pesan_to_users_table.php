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
        Schema::table('users', function (Blueprint $table) {
            $table->text('pesan_pemohon')->nullable()->after('password')->default('Hai Saudara/Saudari {nama}, dokumen permohonan perizinan *{nama_izin}* dengan Nomor Permohonan : {no_permohonan} saat ini sudah pada tahap {tahapan}.\n\n_Pesan ini dikirim oleh {username}_');
            $table->text('pesan_penyerahan')->nullable()->after('pesan_pemohon')->default('Hai Saudara/Saudari {nama}, dokumen permohonan perizinan *{nama_izin}* dengan Nomor Permohonan : {no_permohonan} saat ini sudah pada tahap *{tahapan}*.\n\nSilakan mengambil dokumen Anda sesuai prosedur yang berlaku.\n\n_Softfile Document_: {link_izin}.\n\n_Pesan ini dikirim oleh {username}_');
            $table->text('pesan_pegawai')->nullable()->after('pesan_penyerahan')->default('Notifikasi Permohonan *{tahapan}*\nNama: {nama_pemohon}\nPerihal: {nama_izin}\nNomor: {no_permohonan}\nTgl. Pengajuan: {created_at_wib}\n\nSilakan login ke website sicantik.go.id untuk {tahapan}.\n\n_Pesan ini dikirim oleh {username}_');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
