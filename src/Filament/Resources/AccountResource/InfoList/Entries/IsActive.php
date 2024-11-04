<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

use Filament\Infolists;

class IsActive extends Entry
{
    public static function make(): Infolists\Components\Entry
    {
        return Infolists\Components\IconEntry::make('is_active')
            ->columnSpan(2)
            ->label(trans('filament-accounts::messages.accounts.columns.is_active'))
            ->boolean();
    }
}
