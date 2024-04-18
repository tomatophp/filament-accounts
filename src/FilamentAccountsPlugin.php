<?php

namespace TomatoPHP\FilamentAccounts;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;
use TomatoPHP\FilamentAccounts\Filament\Resources\ContactResource;
use TomatoPHP\FilamentPlugins\Facades\FilamentPlugins;

class FilamentAccountsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-accounts';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                AccountResource::class,
                AccountRequestResource::class,
                ContactResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {

    }

    public static function make(): static
    {
        return new static();
    }
}
