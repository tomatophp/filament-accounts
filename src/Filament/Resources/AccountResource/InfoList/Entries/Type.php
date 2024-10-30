<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

use Filament\Infolists;

class Type extends Entry
{
    public static function make(): Infolists\Components\Entry
    {
        return Infolists\Components\TextEntry::make('type')
            ->label(trans('filament-accounts::messages.accounts.columns.type'));
    }
}
