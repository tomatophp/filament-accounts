<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages;

use Filament\Pages\Page;

class ApiTokens extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static string $view = 'filament-accounts::teams.api-tokens';

    protected static ?string $navigationLabel = 'API Tokens';

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
