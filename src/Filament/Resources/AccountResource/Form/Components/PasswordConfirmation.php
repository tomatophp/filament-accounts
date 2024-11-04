<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class PasswordConfirmation extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\TextInput::make('password_confirmation')
            ->label(trans('filament-accounts::messages.accounts.columns.password_confirmation'))
            ->visible(fn (Forms\Get $get) => $get('is_login'))
            ->password()
            ->maxLength(255);
    }
}
