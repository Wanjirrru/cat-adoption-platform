<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Define the 'api' rate limiter here
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // You can add more limiters later, e.g., for login
        // RateLimiter::for('login', function (Request $request) {
        //     return Limit::perMinute(5)->by($request->ip());
        // });
    }
}