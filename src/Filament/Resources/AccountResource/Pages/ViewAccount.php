<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;

class ViewAccount extends ViewRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return config('filament-accounts.resource.pages.view') ? config('filament-accounts.resource.pages.view')::make($this) : AccountResource\Actions\ViewPageActions::make($this);
    }
}
