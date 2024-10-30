<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class Name extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\TextInput::make('name')
            ->label(trans('filament-accounts::messages.accounts.columns.name'))
            ->columnSpan(2)
            ->required()
            ->maxLength(255);
    }
}
