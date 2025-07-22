<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\Pegawai;
use App\Models\Announcement;
use App\Models\NotifPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('user')->check()) {
            return redirect()->route('dashboard.user');
        }
        return view('user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        if (is_null($user->email_verified_at)) {
            return redirect()->route('signup.otp', ['email' => $user->email])
                ->with('error', 'Akun Anda belum diverifikasi. Silakan masukkan OTP dari email Anda.');
        }

        if (Auth::guard('user')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.user')->with('success', 'Login berhasil! Selamat datang kembali.');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function index()
    {
        $user = Auth::guard('user')->user();
        $pegawai = Pegawai::where('user_id', $user->id)->get();
        $fonnteToken = $user->fonnte;
        $totalPesanTerkirimBulanIni = Pesan::where('user_id', $user->id)
            ->where('status', 'terkirim')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalNotifPegawaiBulanIni = NotifPegawai::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalPesanTerkirim = $totalPesanTerkirimBulanIni + $totalNotifPegawaiBulanIni;
        $fonnteInfo = null;

        if ($fonnteToken) {
            $response = Http::withHeaders([
                'Authorization' => $fonnteToken,
            ])->post('https://api.fonnte.com/device');

            if ($response->successful() && $response->json('status')) {
                $data = $response->json();

                $fonnteInfo = [
                    'device' => $data['device'],
                    'name' => $data['name'],
                    'quota' => $data['quota'],
                    'status' => $data['device_status'],
                    'package' => $data['package'],
                    'expired' => $data['expired'],
                    'messages' => $data['messages'],
                ];
            }
        }
        $announcement = Announcement::get()->all();
        return view('user.dashboard', compact(
            'user',
            'pegawai',
            'fonnteInfo',
            'totalPesanTerkirimBulanIni',
            'totalNotifPegawaiBulanIni',
            'totalPesanTerkirim',
            'announcement'
        ));
    }
    public function settings()
    {
        $user = Auth::guard('user')->user();
        $fonnteToken = $user->fonnte;

        $fonnteInfo = null;

        if ($fonnteToken) {
            $response = Http::withHeaders([
                'Authorization' => $fonnteToken,
            ])->post('https://api.fonnte.com/device');

            if ($response->successful() && $response->json('status')) {
                $data = $response->json();

                $fonnteInfo = [
                    'device' => $data['device'],
                    'name' => $data['name'],
                    'quota' => $data['quota'],
                    'status' => $data['device_status'],
                    'package' => $data['package'],
                    'expired' => $data['expired'],
                    'messages' => $data['messages'],
                ];
            }
        }
        return view('user.setting', compact('user', 'fonnteInfo'));
    }
    public function updateUserConfig(Request $request)
    {
        $user = Auth::guard('user')->user();

        $validator = Validator::make($request->all(), [
            'apirul' => ['nullable', 'url'],
            'fonnte' => ['nullable', 'string'],
            'unit' => ['nullable', 'integer', 'unique:users,unit_id,' . $user->id],
        ], [
            'unit.unique' => 'Unit sudah digunakan oleh pengguna lain.',
            'apirul.url' => 'Format URL tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal memperbarui konfigurasi!');
        }

        $user->api_url = $request->filled('apirul') ? $request->apirul : $user->api_url;
        $user->fonnte = $request->filled('fonnte') ? $request->fonnte : $user->fonnte;
        $user->unit_id = $request->filled('unit') ? $request->unit : $user->unit_id;
        $user->status = $request->has('active') ? 'active' : 'inactive';
        $user->save();

        return redirect()->back()->with('success', 'Konfigurasi berhasil diperbarui!');
    }
    public function pegawai()
    {
        $user = Auth::guard('user')->user();
        $pegawai = Pegawai::where('user_id', $user->id)->get();
        return view('user.pegawai', compact('user', 'pegawai'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20|regex:/^[0-9]+$/',
            'posisi' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);
        Pegawai::create($validated);
        return back()->with('success', 'Pegawai berhasil ditambahkan!');
    }
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->back()->with('success', 'Pegawai berhasil dihapus!');
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:pegawais,id',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20|regex:/^[0-9]+$/',
            'posisi' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $pegawai = Pegawai::findOrFail($validated['id']);
        $pegawai->update([
            'nama' => $validated['nama'],
            'no_hp' => $validated['no_hp'],
            'posisi' => $validated['posisi'],
            'user_id' => $validated['user_id'],
        ]);

        return redirect()->back()->with('success', 'Data pegawai berhasil diupdate!');
    }
    public function pesan(Request $request)
    {
        $user = Auth::guard('user')->user();
        $query = Pesan::where('user_id', $user->id)
            ->with('pemohon');
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('pemohon', function ($q) use ($searchTerm) {
                $q->where('no_permohonan', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $pesan = $query->orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('user.pesan', compact('user', 'pesan'));
    }
    public function pesanPegawai(Request $request)
    {
        $user = Auth::guard('user')->user();
        $query = NotifPegawai::where('user_id', $user->id);
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('nama', 'like', '%' . $searchTerm . '%');
        }
        $pesan = $query->orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();
        return view('user.pesanpeg', compact('user', 'pesan'));
    }
    public function profile()
    {
        $user = Auth::guard('user')->user();
        return view('user.profile', compact('user'));
    }
    public function profileStore(Request $request)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8',
            'confirmpassword' => 'nullable|same:password',
        ], [
            'confirmpassword.same' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($user->save()) {
            Auth::guard('user')->logout();
            return redirect()->route('login')->with('success', 'Profile berhasil diupdate. Silakan login kembali.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
    }
}
