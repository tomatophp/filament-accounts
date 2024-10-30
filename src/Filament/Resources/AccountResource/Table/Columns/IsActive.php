<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Columns;

use Filament\Tables;

class IsActive extends Column
{
    public static function make(): Tables\Columns\Column
    {
        return Tables\Columns\IconColumn::make('is_active')
            ->label(trans('filament-accounts::messages.accounts.columns.is_active'))
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable()
            ->boolean();
    }
}
