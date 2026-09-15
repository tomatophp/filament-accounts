<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Filters;

use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;

class Type extends Filter
{
    public static function make(): BaseFilter
    {
        return SelectFilter::make('type')
            ->label(trans('filament-accounts::messages.accounts.filters.type'))
            ->searchable()
            ->preload()
            ->options(\TomatoPHP\FilamentTypes\Models\Type::query()->where('for', 'accounts')->where('type', 'type')->pluck('name', 'key')->toArray());
    }
}
