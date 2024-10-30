<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\Components;

use Filament\Actions;

class DeleteAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\DeleteAction::make('deleteSelectedAccount');
    }
}
