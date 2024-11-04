<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Filters;

class IsActive extends Filter
{
    public static function make(): \Filament\Tables\Filters\BaseFilter
    {
        return \Filament\Tables\Filters\TernaryFilter::make('is_active')
            ->label(trans('filament-accounts::messages.accounts.filters.is_active'));
    }
}
