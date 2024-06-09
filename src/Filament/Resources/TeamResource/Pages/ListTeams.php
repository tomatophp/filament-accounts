<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\TeamResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAccounts\Filament\Resources\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeams extends ManageRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
