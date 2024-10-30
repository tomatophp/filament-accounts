<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\Components;

use Filament\Actions;

class ViewAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\ViewAction::make();
    }
}
