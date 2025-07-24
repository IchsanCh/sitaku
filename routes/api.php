<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ManualTokenAuth;
use App\Http\Controllers\BillingController;
use App\Http\Middleware\SubscriptionTokenAuth;
use App\Http\Controllers\Api\UserDataController;
use App\Http\Controllers\Api\UserTokenDataController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/v1/ichsan', [UserDataController::class, 'index'])
    ->middleware(ManualTokenAuth::class);
Route::get('/v1/user', [UserTokenDataController::class, 'show'])
    ->middleware(SubscriptionTokenAuth::class);
Route::post('/midtrans/callback', [BillingController::class, 'handleCallback']);
