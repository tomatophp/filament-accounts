<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class Password extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\TextInput::make('password')
            ->label(trans('filament-accounts::messages.accounts.columns.password'))
            ->confirmed()
            ->visible(fn (Forms\Get $get) => $get('is_login'))
            ->password()
            ->maxLength(255);
    }
}
