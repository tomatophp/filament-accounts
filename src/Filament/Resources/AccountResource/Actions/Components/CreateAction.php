<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\Components;

use Filament\Actions;

class CreateAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\CreateAction::make()
            ->using(function (array $data) {
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

                return config('filament-accounts.model')::query()->create($data);
            });
    }
}
