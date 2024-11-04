<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\Components;

use Filament\Actions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\AccountTypes;

class TypesAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\Action::make('types')
            ->icon('heroicon-s-cog')
            ->tooltip('Accounts Types')
            ->label('Accounts Types')
            ->hiddenLabel()
            ->url(AccountTypes::getUrl());
    }
}
