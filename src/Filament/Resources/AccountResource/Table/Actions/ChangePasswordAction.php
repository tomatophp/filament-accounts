<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Actions;

use Filament\Forms;
use Filament\Notifications\Notification;

class ChangePasswordAction extends Action
{
    public static function make(): \Filament\Tables\Actions\Action
    {
        return \Filament\Tables\Actions\Action::make('password')
            ->label(trans('filament-accounts::messages.accounts.actions.password'))
            ->icon('heroicon-s-lock-closed')
            ->iconButton()
            ->tooltip(trans('filament-accounts::messages.accounts.actions.password'))
            ->color('danger')
            ->form([
                Forms\Components\TextInput::make('password')
                    ->label(trans('filament-accounts::messages.accounts.columns.password'))
                    ->password()
                    ->required()
                    ->confirmed()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password_confirmation')
                    ->label(trans('filament-accounts::messages.accounts.columns.password_confirmation'))
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
