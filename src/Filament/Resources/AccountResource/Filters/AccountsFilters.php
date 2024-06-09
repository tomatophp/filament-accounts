<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Filters;

use Filament\Tables;
use Filament\Forms;
use TomatoPHP\FilamentAccounts\Models\Team;
use TomatoPHP\FilamentHelpers\Contracts\FiltersBuilder;
use TomatoPHP\FilamentTypes\Models\Type;

class AccountsFilters extends FiltersBuilder
{
    public function filters(): array
    {
        $filters = [
            Tables\Filters\TrashedFilter::make(),
        ];

        if(filament('filament-accounts')->useTypes){
            $filters[] = Tables\Filters\SelectFilter::make('type')
                ->label(trans('filament-accounts::messages.accounts.filters.type'))
                ->searchable()
                ->preload()
                ->options(Type::query()->where('for', 'accounts')->where('type', 'type')->pluck('name', 'key')->toArray());
        }

        if(filament('filament-accounts')->useTeams) {
            $filters[] = Tables\Filters\SelectFilter::make('teams')
                ->label(trans('filament-accounts::messages.accounts.filters.teams'))
                ->searchable()
                ->preload()
                ->relationship('teams', 'name')
                ->options(Team::query()->pluck('name', 'id')->toArray());
        }

        if(filament('filament-accounts')->canLogin) {
            $filters[] = Tables\Filters\TernaryFilter::make('is_login')
                ->label(trans('filament-accounts::messages.accounts.filters.is_login'));
        }

        if(filament('filament-accounts')->canBlocked) {
            $filters[] = Tables\Filters\TernaryFilter::make('is_active')
                ->label(trans('filament-accounts::messages.accounts.filters.is_active'));
        }
        return $filters;
    }
}
