<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentAccounts\Models\Account;

class ListAccounts extends ManageRecords
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data) {
                    if($data['loginBy'] === 'email'){
                        $data['username'] = $data['email'];
                    }
                    else {
                        $data['username'] = $data['phone'];
                    }

                    return Account::query()->create($data);
                }),
        ];
    }
}
