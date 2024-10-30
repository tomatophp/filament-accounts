<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Columns;

use Filament\Tables;

class IsLogin extends Column
{
    public static function make(): Tables\Columns\Column
    {
        return Tables\Columns\IconColumn::make('is_login')
            ->label(trans('filament-accounts::messages.accounts.columns.is_login'))
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable()
            ->boolean();
    }
}
