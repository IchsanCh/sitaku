<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomPesanController extends Controller
{
    public function pesanPemohon(Request $request)
    {
        $user = Auth::guard('user')->user();

        if ($request->isMethod('post')) {
            if ($request->has('reset')) {
                // reset pesan di database
                $user->update(['pesan_pemohon' => 'Hai Saudara/Saudari {nama}, dokumen permohonan perizinan *{nama_izin}* dengan Nomor Permohonan : {no_permohonan} saat ini sudah pada tahap {tahapan}.\n\n_Pesan ini dikirim oleh {username}_']);
                return redirect()->back()->with('success', 'Pesan pemohon berhasil direset ke default!');
            }

            // validasi & simpan normal
            $request->validate([
                'isi_pesan' => 'string|max:500',
            ]);

            $user->update([
                'pesan_pemohon' => $request->isi_pesan,
            ]);

            return redirect()->back()->with('success', 'Pesan pemohon berhasil disimpan!');
        }

        return view('user.pesan-pemohon', compact('user'));
    }


    public function pesanPenyerahan(Request $request)
    {
        $user = Auth::guard('user')->user();

        if ($request->isMethod('post')) {
            if ($request->has('reset')) {
                // reset pesan di database
                $user->update(['pesan_penyerahan' => 'Hai Saudara/Saudari {nama}, dokumen permohonan perizinan *{nama_izin}* dengan Nomor Permohonan : {no_permohonan} saat ini sudah pada tahap *{tahapan}*.\n\nSilakan mengambil dokumen Anda sesuai prosedur yang berlaku.\n\n_Softfile Document_: {link_izin}.\n\n_Pesan ini dikirim oleh {username}_']);
                return redirect()->back()->with('success', 'Pesan penyerahan berhasil direset ke default!');
            }

            // validasi & simpan normal
            $request->validate([
                'isi_pesan' => 'string|max:500',
            ]);

            $user->update([
                'pesan_penyerahan' => $request->isi_pesan,
            ]);

            return redirect()->back()->with('success', 'Pesan penyerahan berhasil disimpan!');
        }

        return view('user.pesan-penyerahan', compact('user'));
    }

    public function pesanPegawai(Request $request)
    {
        $user = Auth::guard('user')->user();

        if ($request->isMethod('post')) {
            if ($request->has('reset')) {
                // reset pesan di database
                $user->update(['pesan_pegawai' => 'Notifikasi Permohonan *{tahapan}*\nNama: {nama_pemohon}\nPerihal: {nama_izin}\nNomor: {no_permohonan}\nTgl. Pengajuan: {created_at_wib}\n\nSilakan login ke website sicantik.go.id untuk {tahapan}.\n\n_Pesan ini dikirim oleh {username}_']);
                return redirect()->back()->with('success', 'Pesan pegawai berhasil direset ke default!');
            }

            // validasi & simpan normal
            $request->validate([
                'isi_pesan' => 'string|max:500',
            ]);

            $user->update([
                'pesan_pegawai' => $request->isi_pesan,
            ]);

            return redirect()->back()->with('success', 'Pesan penyerahan berhasil disimpan!');
        }

        return view('user.pesan-pegawai', compact('user'));
    }
}
