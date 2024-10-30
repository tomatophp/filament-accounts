<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions;

final class EditPageActions
{
    use Contracts\CanRegister;

    public function getDefaultActions(): array
    {
        return [
            Components\ViewAction::make(),
            Components\DeleteAction::make(),
        ];
    }
}
