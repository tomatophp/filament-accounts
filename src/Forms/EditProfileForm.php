<?php

namespace TomatoPHP\FilamentAccounts\Forms;

use Filament\Forms;

class EditProfileForm
{
    public static function get(): array
    {
        return [
            Forms\Components\Section::make(trans('filament-accounts::messages.profile.edit.title'))
                ->description(trans('filament-accounts::messages.profile.edit.description'))
                ->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                        ->avatar()
                        ->circleCropper()
                        ->collection('avatar')
                        ->columnSpan(2)
                        ->label(trans('filament-accounts::messages.accounts.coulmns.avatar')),
                    Forms\Components\TextInput::make('name')
                        ->columnSpan(2)
                        ->label(trans('filament-accounts::messages.profile.edit.name'))
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->columnSpan(2)
                        ->label(trans('filament-accounts::messages.profile.edit.email'))
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),
                ]),
        ];
    }
}
