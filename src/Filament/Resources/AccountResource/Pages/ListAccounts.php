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
                    if(isset($data['password'])){
                        $data['password'] = bcrypt($data['password']);
                    }
                    if(isset($data['loginBy']) && $data['loginBy'] === 'email'){
                        $data['username'] = $data['email'];
                    }
                    else if(isset($data['loginBy']) && $data['loginBy'] === 'phone') {
                        $data['username'] = $data['phone'];
                    }
                    else {
                        $data['username'] = $data['email'];
                    }

                    return config('filament-accounts.model')::query()->create($data);
                }),
        ];
    }
}
