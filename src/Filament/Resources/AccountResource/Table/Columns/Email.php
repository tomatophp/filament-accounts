<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Columns;

use Filament\Tables;

class Email extends Column
{
    public static function make(): Tables\Columns\Column
    {
        return Tables\Columns\TextColumn::make('email')
            ->label(trans('filament-accounts::messages.accounts.columns.email'))
            ->toggleable(isToggledHiddenByDefault: filament('filament-accounts')->useAvatar)
            ->sortable()
            ->searchable();
    }
}
