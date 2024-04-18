<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource\Pages;

use TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountRequest extends EditRecord
{
    protected static string $resource = AccountRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
