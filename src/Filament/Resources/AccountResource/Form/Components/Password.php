<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;

class Password extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\TextInput::make('password')
            ->label(trans('filament-accounts::messages.accounts.columns.password'))
            ->confirmed()
            ->visible(fn (Get $get) => $get('is_login'))
            ->password()
            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
            ->maxLength(255);
    }
}
