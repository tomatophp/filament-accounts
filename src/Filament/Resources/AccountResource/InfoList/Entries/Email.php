<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

use Filament\Infolists;

class Email extends Entry
{
    public static function make(): Infolists\Components\Entry
    {
        return Infolists\Components\TextEntry::make('email')
            ->label(trans('filament-accounts::messages.accounts.columns.email'));
    }
}
