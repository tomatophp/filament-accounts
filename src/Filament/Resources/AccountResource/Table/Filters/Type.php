<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Filters;

class Type extends Filter
{
    public static function make(): \Filament\Tables\Filters\BaseFilter
    {
        return \Filament\Tables\Filters\SelectFilter::make('type')
            ->label(trans('filament-accounts::messages.accounts.filters.type'))
            ->searchable()
            ->preload()
            ->options(\TomatoPHP\FilamentTypes\Models\Type::query()->where('for', 'accounts')->where('type', 'type')->pluck('name', 'key')->toArray());
    }
}
