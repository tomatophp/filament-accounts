<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;

class ManageAccounts extends ManageRecords
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return config('filament-accounts.resource.pages.list') ? config('filament-accounts.resource.pages.list')::make($this) : AccountResource\Actions\ManagePageActions::make($this);
    }
}
