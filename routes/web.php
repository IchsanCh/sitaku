<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DocsController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/signup', [HomeController::class, 'signup'])->name('signup');
Route::post('/signup', [HomeController::class, 'storeSignup'])->name('signup.store');
Route::get('/signup/otp', [HomeController::class, 'showOtp'])->name('signup.otp');
Route::post('/signup/verify', [HomeController::class, 'verifyOtp'])->name('signup.verify');
Route::get('/signup/otp/resend', [HomeController::class, 'resendOtp'])->name('signup.otp.resend');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/docs/{page?}', [DocsController::class, 'show'])->name('docs')->where('page', '.*');

Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.user');

Route::middleware('auth:user')->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout.user');
    Route::get('/dashboard', [UserAuthController::class, 'index'])->name('dashboard.user');
    Route::get('/profile', [UserAuthController::class, 'profile'])->name('profile.user');
    Route::post('/profile/update', [UserAuthController::class, 'profileStore'])->name('profile.update');
    Route::get('/settings', [UserAuthController::class, 'settings'])->name('setting.user');
    Route::post('/setting/update', [UserAuthController::class, 'updateUserConfig'])->name('setting.update');
    Route::get('/pegawai', [UserAuthController::class, 'pegawai'])->name('user.pegawai');
    Route::post('/pegawai', [UserAuthController::class, 'store'])->name('pegawai.store');
    Route::delete('/pegawai/{id}', [UserAuthController::class, 'destroy'])->name('pegawai.destroy');
    Route::put('/pegawai/update', [UserAuthController::class, 'update'])->name('pegawai.update');
    Route::get('/pesan', [UserAuthController::class, 'pesan'])->name('pesan.user');
    Route::get('/pesan/pegawai', [UserAuthController::class, 'pesanPegawai'])->name('pesan.pegawai');
    Route::get('/billing', [BillingController::class, 'index'])->name('user.billing');
    Route::post('/billing/pay', [BillingController::class, 'pay'])->name('billing.pay');
    Route::get('/billing/success', [BillingController::class, 'paymentSuccess'])->name('billing.success');
});
Route::post('/midtrans/callback', [BillingController::class, 'handleCallback']);
