<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;

class Phone extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\TextInput::make('phone')
            ->label(trans('filament-accounts::messages.accounts.columns.phone'))
            ->required(fn (Get $get) => $get('loginBy') === 'phone')
            ->tel()
            ->maxLength(255);
    }
}
