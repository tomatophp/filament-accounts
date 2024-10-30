<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

use Filament\Infolists;

class LoginBy extends Entry
{
    public static function make(): Infolists\Components\Entry
    {
        return Infolists\Components\TextEntry::make('loginBy')
            ->label(trans('filament-accounts::messages.accounts.columns.loginBy'));
    }
}
