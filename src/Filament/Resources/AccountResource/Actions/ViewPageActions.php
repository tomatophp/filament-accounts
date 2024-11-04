<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions;

final class ViewPageActions
{
    use Contracts\CanRegister;

    public function getDefaultActions(): array
    {
        return [
            //            Components\EditAction::make(),
            //            Components\DeleteAction::make(),
        ];
    }
}
