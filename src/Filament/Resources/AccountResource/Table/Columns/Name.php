<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Columns;

use Filament\Tables;

class Name extends Column
{
    public static function make(): Tables\Columns\Column
    {
        return Tables\Columns\TextColumn::make('name')
            ->label(trans('filament-accounts::messages.accounts.columns.name'))
            ->toggleable(isToggledHiddenByDefault: filament('filament-accounts')->useAvatar)
            ->sortable()
            ->searchable();
    }
}
