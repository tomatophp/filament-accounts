<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use TomatoPHP\FilamentAccounts\Models\Team;

class AccountTeamsAction
{
     public static function make(): Action
     {
         return Action::make('teams')
             ->label(trans('filament-accounts::messages.accounts.actions.teams'))
             ->icon('heroicon-s-user-group')
             ->iconButton()
             ->tooltip(trans('filament-accounts::messages.accounts.actions.teams'))
             ->color('primary')
             ->form(function ($record) {
                 return [
                     Forms\Components\Select::make('teams')
                         ->default($record->teams()->pluck('team_id')->toArray())
                         ->multiple()
                         ->label(trans('filament-accounts::messages.accounts.actions.teams'))
                         ->preload()
                         ->required()
                         ->relationship('teams', 'name')
                         ->options(Team::query()->pluck('name', 'id')->toArray())
                 ];
             })
             ->action(function (array $data, $record) {
                 Notification::make()
                     ->title('Account Teams Updated')
                     ->body('Account Teams Updated successfully')
                     ->success()
                     ->send();
             });
     }
}
