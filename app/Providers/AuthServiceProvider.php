<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Document;
use App\Models\Language;
use App\Models\Theme;
use App\Policies\DocumentPolicy;
use App\Policies\LanguagePolicy;
use App\Policies\ThemePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Document::class => DocumentPolicy::class,
        Language::class => LanguagePolicy::class,
        Theme::class => ThemePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
