<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\CustomPesanController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/docs/{page?}', [DocsController::class, 'show'])->name('docs')->where('page', '.*');

Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.user');

Route::middleware('auth:user')->group(function () {
    Route::middleware('feature:custom_pesan')->group(function () {
        Route::match(['get', 'post'], '/user/pesan/pemohon', [CustomPesanController::class, 'pesanPemohon'])->name('custom.pesan.pemohon');
        Route::match(['get', 'post'], '/user/pesan/penyerahan', [CustomPesanController::class, 'pesanPenyerahan'])->name('custom.pesan.penyerahan');
        Route::match(['get', 'post'], '/user/pesan/pegawai', [CustomPesanController::class, 'pesanPegawai'])->name('custom.pesan.pegawai');
    });

    // Lihat & edit slot yang ADA -- kebuka buat semua tier (Basic termasuk),
    // soalnya semua user otomatis punya 3 menu default sejak signup.
    Route::get('/user/menu', [MenuItemController::class, 'index'])->name('menu.index');
    Route::get('/user/menu/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('menu.edit');
    Route::put('/user/menu/{menuItem}', [MenuItemController::class, 'update'])->name('menu.update');

    // Nambah slot baru / hapus slot -- ini yang tetep eksklusif tier yang punya
    // feature 'state_machine' (Premium ke atas).
    Route::middleware('feature:state_machine')->group(function () {
        Route::get('/user/menu/create', [MenuItemController::class, 'create'])->name('menu.create');
        Route::post('/user/menu', [MenuItemController::class, 'store'])->name('menu.store');
        Route::delete('/user/menu/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu.destroy');
    });

    // Balasan cepat buat admin support -- numpang di feature yang sama kayak
    // live_support (satu kesatuan: gak ada gunanya punya quick reply kalau
    // instansi-nya gak punya live support), tapi model & migration-nya sendiri.
    Route::middleware('feature:menu_action_live_support')->group(function () {
        Route::resource('user/quick-replies', \App\Http\Controllers\QuickReplyController::class)
            ->except(['show'])
            ->names('quick-reply')
            ->parameters(['user/quick-replies' => 'quickReply']);

        Route::resource('user/admin-supports', \App\Http\Controllers\AdminSupportController::class)
            ->except(['show'])
            ->names('admin-support')
            ->parameters(['user/admin-supports' => 'adminSupport']);
    });
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
    Route::get('/billing/status/{payToken}', [BillingController::class, 'paketStatus'])->name('billing.status');
    Route::get('/billing/success', [BillingController::class, 'paymentSuccess'])->name('billing.success');
});

Route::prefix('support')->name('support.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Support\SupportAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Support\SupportAuthController::class, 'login'])->name('login.submit');

    Route::get('/forgot-password', [\App\Http\Controllers\Support\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Support\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Support\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Support\ResetPasswordController::class, 'reset'])->name('password.update');

    Route::middleware('auth:support')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Support\SupportAuthController::class, 'logout'])->name('logout');
        Route::get('/', [\App\Http\Controllers\Support\LiveChatSupportController::class, 'index'])->name('inbox');
        Route::get('/chat/{liveChat}', [\App\Http\Controllers\Support\LiveChatSupportController::class, 'show'])->name('chat.show');
        Route::post('/chat/{liveChat}/reply', [\App\Http\Controllers\Support\LiveChatSupportController::class, 'reply'])->name('chat.reply');
        Route::post('/chat/{liveChat}/end', [\App\Http\Controllers\Support\LiveChatSupportController::class, 'endSession'])->name('chat.end');
    });
});

// Route::get('/test-error/{code}', [ErrorController::class, 'show'])
//     ->whereNumber('code');