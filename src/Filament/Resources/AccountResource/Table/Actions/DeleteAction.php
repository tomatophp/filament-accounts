<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Actions;

use Filament\Tables;

class DeleteAction extends Action
{
    public static function make(): Tables\Actions\Action
    {
        return Tables\Actions\DeleteAction::make()
            ->iconButton()
            ->tooltip(__('filament-actions::delete.single.label'));
    }
}
