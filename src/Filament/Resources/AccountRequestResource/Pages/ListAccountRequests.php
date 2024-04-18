<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountRequests extends ManageRecords
{
    protected static string $resource = AccountRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
