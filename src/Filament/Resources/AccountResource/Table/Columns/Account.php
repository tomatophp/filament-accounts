<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Columns;

use Filament\Tables;
use TomatoPHP\FilamentAccounts\Components\AccountColumn;

class Account extends Column
{
    public static function make(): Tables\Columns\Column
    {
        return AccountColumn::make('id')
            ->label(trans('filament-accounts::messages.accounts.columns.account'))
            ->toggleable()
            ->sortable();
    }
}
