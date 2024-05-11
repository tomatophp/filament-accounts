<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Filters;

use Filament\Tables;
use Filament\Forms;
use TomatoPHP\FilamentHelpers\Contracts\FiltersBuilder;
use TomatoPHP\FilamentTypes\Models\Type;

class AccountsFilters extends FiltersBuilder
{
    public function filters(): array
    {
        return [
            Tables\Filters\TrashedFilter::make(),
            Tables\Filters\SelectFilter::make('type')
                ->label(trans('filament-accounts::messages.accounts.filters.type'))
                ->searchable()
                ->options(Type::query()->where('for', 'accounts')->where('type', 'type')->pluck('name', 'key')->toArray())
        ];
    }
}
