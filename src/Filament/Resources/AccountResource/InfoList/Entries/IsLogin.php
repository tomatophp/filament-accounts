<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

use Filament\Infolists;

class IsLogin extends Entry
{
    public static function make(): Infolists\Components\Entry
    {
        return Infolists\Components\IconEntry::make('is_login')->default(false)
            ->columnSpan(2)
            ->label(trans('filament-accounts::messages.accounts.columns.is_login'))
            ->boolean();
    }
}
