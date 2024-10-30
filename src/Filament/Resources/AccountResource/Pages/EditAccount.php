<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use Filament\Resources\Pages\EditRecord;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return config('filament-accounts.resource.pages.edit') ? config('filament-accounts.resource.pages.edit')::make($this) : AccountResource\Actions\EditPageActions::make($this);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return $data;
    }
}
