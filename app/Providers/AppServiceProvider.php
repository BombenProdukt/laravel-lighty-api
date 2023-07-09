<?php

declare(strict_types=1);

namespace App\Providers;

use App\View\Components\Lighty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Model::unguard();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('lighty', Lighty::class);

        if ($this->app->environment('local')) {
            Auth::loginUsingId(1);
        }
    }
}
