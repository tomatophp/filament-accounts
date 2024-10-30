<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

use Filament\Infolists;

class Avatar extends Entry
{
    public static function make(): Infolists\Components\Entry
    {
        return Infolists\Components\SpatieMediaLibraryImageEntry::make('avatar')
            ->alignCenter()
            ->collection('avatar')
            ->columnSpan(2)
            ->columnSpanFull()
            ->label(trans('filament-accounts::messages.accounts.columns.avatar'));
    }
}
