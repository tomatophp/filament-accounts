<?php

namespace TomatoPHP\FilamentAccounts\Forms;

use Filament\Forms;

class EditProfileForm
{
    public static function get(): array
    {
        return [
            Forms\Components\Section::make(trans('filament-accounts::messages.profile_information'))
                ->aside()
                ->description(trans('filament-accounts::messages.profile_information_description'))
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(trans('filament-accounts::messages.name'))
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label(trans('filament-accounts::messages.email'))
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),
                ]),
        ];
    }
}
