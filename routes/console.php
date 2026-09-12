<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Cutoff proaktif buat room live chat yang instansinya udah gak eligible
// lagi (downgrade/expired) -- pelengkap cutoff reaktif yang ada di
// FonnteWebhookController (itu baru jalan kalau ada pesan masuk baru).
Schedule::command('live-chat:enforce-tier-limits')->everyMinute();