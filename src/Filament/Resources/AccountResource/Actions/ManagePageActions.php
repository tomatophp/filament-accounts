<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions;

final class ManagePageActions
{
    use Contracts\CanRegister;

    public function getDefaultActions(): array
    {
        return [
            Components\CreateAction::make(),
        ];
    }
}
