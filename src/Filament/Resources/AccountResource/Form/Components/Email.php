<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class Email extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\TextInput::make('email')
            ->label(trans('filament-accounts::messages.accounts.columns.email'))
            ->required(fn (Forms\Get $get) => $get('loginBy') === 'email')
            ->email()
            ->maxLength(255);
    }
}
