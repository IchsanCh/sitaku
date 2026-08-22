<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('support')->check()) {
            return redirect()->route('support.inbox');
        }

        return view('support.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::guard('support')->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $agent = Auth::guard('support')->user();

        if (! $agent->is_active) {
            Auth::guard('support')->logout();
            return back()->withErrors(['email' => 'Akun ini nonaktif. Hubungi admin instansi Anda.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('support.inbox');
    }

    public function logout(Request $request)
    {
        Auth::guard('support')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('support.login');
    }
}