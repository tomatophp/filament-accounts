<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

use Filament\Infolists;

class Address extends Entry
{
    public static function make(): Infolists\Components\Entry
    {
        return Infolists\Components\TextEntry::make('address')
            ->label(trans('filament-accounts::messages.accounts.columns.address'))
            ->columnSpanFull();
    }
}
