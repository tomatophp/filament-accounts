<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Releations;

use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;

class AccountReleations
{
    public static function get(): array
    {
        $loadRelations = FilamentAccounts::loadRelations();
        return array_merge([
            \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\RelationManagers\AccountMetaManager::make(),
            \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\RelationManagers\AccountLocationsManager::make(),
            \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\RelationManagers\AccountRequestsManager::make(),
        ],$loadRelations);
    }
}
