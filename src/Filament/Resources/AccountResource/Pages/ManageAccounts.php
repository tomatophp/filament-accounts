<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;

class ManageAccounts extends ManageRecords
{
    protected static string $resource = AccountResource::class;

    public function getHeaderActions(): array
    {
        return FilamentAccounts::getActions(self::class);
    }
}
