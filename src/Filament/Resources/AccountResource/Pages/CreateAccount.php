<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if(isset($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }
        if(!isset($data['loginBy'])){
            $data['loginBy'] = "email";
        }
    }
}
