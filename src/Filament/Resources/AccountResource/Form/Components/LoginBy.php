<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class LoginBy extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\Select::make('loginBy')
            ->label(trans('filament-accounts::messages.accounts.columns.loginBy'))
            ->searchable()
            ->options([
                'email' => trans('filament-accounts::messages.accounts.columns.email'),
                'phone' => trans('filament-accounts::messages.accounts.columns.phone'),
            ])
            ->required()
            ->default('email');
    }
}
