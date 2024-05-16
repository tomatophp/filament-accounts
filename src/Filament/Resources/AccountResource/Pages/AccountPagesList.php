<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

class AccountPagesList
{
    public static function routes(): array
    {
        return [
            'index' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\ListAccounts::route('/'),
            'edit' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
