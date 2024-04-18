<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Pages\ViewRecord;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentAccounts\Models\Account;

class ViewAccount extends ViewRecord
{
    protected static string $resource = AccountResource::class;
}
