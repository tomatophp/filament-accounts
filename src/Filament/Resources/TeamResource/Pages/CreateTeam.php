<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\TeamResource\Pages;

use TomatoPHP\FilamentAccounts\Filament\Resources\TeamResource;
use TomatoPHP\FilamentAccounts\Models\Team;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;
}
