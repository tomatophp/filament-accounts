<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Actions;

use Filament\Tables;

class EditAction extends Action
{
    public static function make(): Tables\Actions\Action
    {
        return Tables\Actions\EditAction::make()
            ->iconButton()
            ->tooltip(__('filament-actions::edit.single.label'));
    }
}
