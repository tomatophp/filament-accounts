<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

use Filament\Infolists;

class Phone extends Entry
{
    public static function make(): Infolists\Components\Entry
    {
        return Infolists\Components\TextEntry::make('phone')
            ->label(trans('filament-accounts::messages.accounts.columns.phone'));
    }
}
