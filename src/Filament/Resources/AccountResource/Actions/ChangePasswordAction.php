<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Forms;

class ChangePasswordAction
{
    public static function make(): Action
    {
        return Action::make('password')
            ->label(trans('filament-accounts::messages.accounts.actions.password'))
            ->icon('heroicon-s-lock-closed')
            ->iconButton()
            ->tooltip(trans('filament-accounts::messages.accounts.actions.password'))
            ->color('danger')
            ->form([
                Forms\Components\TextInput::make('password')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.password'))
                    ->password()
                    ->required()
                    ->confirmed()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password_confirmation')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.password_confirmation'))
                    ->password()
                    ->required()
                    ->maxLength(255),
            ])
            ->action(function (array $data, $record) {
                $record->password = bcrypt($data['password']);
                $record->save();

                Notification::make()
                    ->title('Account Password Changed')
                    ->body('Account password changed successfully')
                    ->success()
                    ->send();
            });
    }
}
