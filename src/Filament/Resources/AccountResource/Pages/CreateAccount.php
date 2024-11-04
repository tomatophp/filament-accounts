<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        if (isset($data['loginBy']) && $data['loginBy'] === 'email' && ! empty($data['email'])) {
            $data['username'] = $data['email'];
        } elseif (isset($data['loginBy']) && $data['loginBy'] === 'phone' && ! empty($data['phone'])) {
            $data['username'] = $data['phone'];
        } else {
            $data['username'] = str($data['name'])->slug()->toString();
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return config('filament-accounts.resource.pages.create') ? config('filament-accounts.resource.pages.create')::make($this) : AccountResource\Actions\CreatePageActions::make($this);
    }
}
