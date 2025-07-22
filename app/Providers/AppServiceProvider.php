<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadHelpers();
        Carbon::setLocale('id');
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            return url("/reset-password/{$token}?email=" . urlencode($notifiable->email));
        });
    }
    protected function loadHelpers()
    {
        if (!function_exists('highlightSearchTerm')) {
            function highlightSearchTerm($text, $searchTerm)
            {
                if (empty($searchTerm)) {
                    return e($text);
                }

                $highlightedText = preg_replace(
                    '/(' . preg_quote($searchTerm, '/') . ')/i',
                    '<mark class="bg-yellow-200 text-yellow-900 px-1 rounded">$1</mark>',
                    e($text)
                );

                return $highlightedText;
            }
        }
    }
}
