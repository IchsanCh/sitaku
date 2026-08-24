<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Mail\SupportResetPasswordMail;
use App\Models\AdminSupport;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('support.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admin_supports,email',
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ]);

        $agent = AdminSupport::where('email', $request->email)->first();

        $token = Str::random(60);

        // Tabel sendiri (admin_support_password_reset_tokens), BUKAN password_reset_tokens
        // yang dipakai users/admins -- biar gak tabrakan token kalau email-nya kebetulan sama.
        DB::table('admin_support_password_reset_tokens')->updateOrInsert(
            ['email' => $agent->email],
            [
                'email' => $agent->email,
                'token' => bcrypt($token),
                'created_at' => now(),
            ]
        );

        Mail::to($agent->email)->queue(new SupportResetPasswordMail($token, $agent->email));

        return back()->with('status', 'Link reset password sudah dikirim ke email kamu!');
    }
}