<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Columns;

use Filament\Tables;
use TomatoPHP\FilamentTypes\Components\TypeColumn;

class Type extends Column
{
    public static function make(): Tables\Columns\Column
    {
        return TypeColumn::make('type')
            ->label(trans('filament-accounts::messages.accounts.columns.type'))
            ->toggleable()
            ->sortable()
            ->searchable();
    }
}
