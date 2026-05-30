<?php

namespace App\Providers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // API routes should never redirect to a login page
        AuthenticationException::redirectUsing(fn() => null);
    }
}
