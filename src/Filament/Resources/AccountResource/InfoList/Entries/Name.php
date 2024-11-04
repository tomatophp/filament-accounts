<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

use Filament\Infolists;

class Name extends Entry
{
    public static function make(): Infolists\Components\Entry
    {
        return Infolists\Components\TextEntry::make('name')
            ->label(trans('filament-accounts::messages.accounts.columns.name'))
            ->columnSpan(2);
    }
}
