<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Filters;

class IsLogin extends Filter
{
    public static function make(): \Filament\Tables\Filters\BaseFilter
    {
        return \Filament\Tables\Filters\TernaryFilter::make('is_login')
            ->label(trans('filament-accounts::messages.accounts.filters.is_login'));
    }
}
