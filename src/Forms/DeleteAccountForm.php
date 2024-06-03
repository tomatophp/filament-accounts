<?php

namespace TomatoPHP\FilamentAccounts\Forms;

use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DeleteAccountForm
{
    public static function get(): array
    {
        return [
            Section::make(trans('filament-accounts::messages.delete_account'))
                ->description(trans('filament-accounts::messages.delete_account_description'))
                ->aside()
                ->schema([
                    Forms\Components\ViewField::make('deleteAccount')
                        ->label(__('Delete Account'))
                        ->hiddenLabel()
                        ->view('filament-accounts::forms.components.delete-account-description'),
                    Actions::make([
                        Actions\Action::make('deleteAccount')
                            ->label(trans('filament-accounts::messages.delete_account'))
                            ->icon('heroicon-m-trash')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->modalHeading(trans('filament-accounts::messages.delete_account'))
                            ->modalDescription(trans('filament-accounts::messages.are_you_sure'))
                            ->modalSubmitActionLabel(trans('filament-accounts::messages.yes_delete_it'))
                            ->form([
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->revealable()
                                    ->label(trans('filament-accounts::messages.password'))
                                    ->required(),
                            ])
                            ->action(function (array $data) {

                                if (! Hash::check($data['password'], Auth::user()->password)) {
                                    self::sendErrorDeleteAccount(trans('filament-accounts::messages.incorrect_password'));

                                    return;
                                }

                                auth()->user()?->update([
                                    'active' => false,
                                ]);

                                auth()->user()?->delete();
                            }),
                    ]),
                ]),
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
