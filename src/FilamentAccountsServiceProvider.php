<?php

namespace TomatoPHP\FilamentAccounts;

use Illuminate\Support\ServiceProvider;

class FilamentAccountsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register generate command
        $this->commands([
            \TomatoPHP\FilamentAccounts\Console\FilamentAccountsInstall::class,
        ]);

        // Register Config file
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-accounts.php', 'filament-accounts');

        // Publish Config
        $this->publishes([
            __DIR__ . '/../config/filament-accounts.php' => config_path('filament-accounts.php'),
        ], 'filament-accounts-config');

        // Register Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish Migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'filament-accounts-migrations');
        // Register views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-accounts');

        // Publish Views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-accounts'),
        ], 'filament-accounts-views');

        // Register Langs
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-accounts');

        // Publish Lang
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('lang/vendor/filament-accounts'),
        ], 'filament-accounts-lang');

        $this->publishes([
            __DIR__ . '/../publish/Account.php' => app_path('Models/Account.php'),
        ], 'filament-accounts-model');

        $this->app->bind('filament-accounts', function () {
            return new \TomatoPHP\FilamentAccounts\Services\FilamentAccountsServices;
        });
    }

    public function boot(): void
    {
        //
    }
}
