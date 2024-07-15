<?php

namespace TomatoPHP\FilamentAccounts\Forms;

use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateTeamForm
{
    public static function get($team): array
    {
        return [
            Forms\Components\ViewField::make('teamOwner')
                ->label(trans('filament-accounts::messages.teams.edit.owner'))
                ->hiddenLabel()
                ->view('filament-accounts::forms.components.team-owner', ['team' => $team]),
            SpatieMediaLibraryFileUpload::make('avatar')
                ->avatar()
                ->label(trans('filament-accounts::messages.teams.edit.avatar'))
                ->disabled(fn() => auth('accounts')->user()->id !== $team->account_id)
                ->collection('avatar'),
            TextInput::make('name')
                ->label(trans('filament-accounts::messages.teams.edit.name'))
                ->disabled(fn() => auth('accounts')->user()->id !== $team->account_id)
                ->required(),
        ];
    }

    public static function sendErrorDeleteAccount(string $message): void
    {
        Notification::make()
            ->danger()
            ->title($message)
            ->send();
    }
}
