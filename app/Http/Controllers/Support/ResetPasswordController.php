<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\AdminSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('support.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $reset = DB::table('admin_support_password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $reset || ! Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['email' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        $agent = AdminSupport::where('email', $request->email)->first();
        $agent->password = Hash::make($request->password);
        $agent->save();

        DB::table('admin_support_password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('support.login')->with('success', 'Password berhasil direset!');
    }
}