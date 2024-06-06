<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ApiTokens extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static string $view = 'filament-accounts::teams.api-tokens';

    public static function getNavigationLabel(): string
    {
        return trans('filament-accounts::messages.profile.token.title');
    }

    public function getTitle(): string|Htmlable
    {
        return trans('filament-accounts::messages.profile.token.title');
    }

    /**
     * @return bool
     */
    public static function isShouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
