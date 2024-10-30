<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Columns;

use Filament\Tables;

class Phone extends Column
{
    public static function make(): Tables\Columns\Column
    {
        return Tables\Columns\TextColumn::make('phone')
            ->label(trans('filament-accounts::messages.accounts.columns.phone'))
            ->toggleable(isToggledHiddenByDefault: filament('filament-accounts')->useAvatar)
            ->sortable()
            ->searchable();
    }
}
