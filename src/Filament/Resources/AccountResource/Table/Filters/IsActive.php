<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Filters;

use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\TernaryFilter;

class IsActive extends Filter
{
    public static function make(): BaseFilter
    {
        return TernaryFilter::make('is_active')
            ->label(trans('filament-accounts::messages.accounts.filters.is_active'));
    }
}
