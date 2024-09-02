<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions;

use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Actions;
use Filament\Forms;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;
use TomatoPHP\FilamentAccounts\Models\Team;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Services\SendNotification;
use TomatoPHP\FilamentHelpers\Contracts\ActionsBuilder;
use TomatoPHP\FilamentIcons\Components\IconPicker;

class AccountsTableActions extends ActionsBuilder
{
    public function actions(): array
    {
        $actions = collect([]);

        //Impersonate
        if(class_exists(\STS\FilamentImpersonate\Tables\Actions\Impersonate::class) && filament('filament-accounts')->canLogin && filament('filament-accounts')->useImpersonate){
           $actions->push(AccountImpersonateAction::make());
        }

        //Change Password
        if(filament('filament-accounts')->canLogin) {
            $actions->push(ChangePasswordAction::make());
        }

        //Teams
        if(filament('filament-accounts')->useTeams) {
            $actions->push(AccountTeamsAction::make());
        }

        //Notifications
        if(filament('filament-accounts')->useNotifications){
            $actions->push(AccountNotificationsAction::make());
        }


        //Merge Default Actions
        $actions = $actions->merge([
            Tables\Actions\EditAction::make()
                ->iconButton()
                ->tooltip(trans('filament-accounts::messages.accounts.actions.edit')),
            Tables\Actions\DeleteAction::make()
                ->iconButton()
                ->tooltip(trans('filament-accounts::messages.accounts.actions.delete')),
            Tables\Actions\ForceDeleteAction::make()
                ->iconButton()
                ->tooltip(trans('filament-accounts::messages.accounts.actions.force_delete')),
            Tables\Actions\RestoreAction::make()
                ->iconButton()
                ->tooltip(trans('filament-accounts::messages.accounts.actions.restore'))
        ]);

        //Merge Provider Actions
        $actions = $actions->merge(FilamentAccounts::loadActions());

        return $actions->toArray();
    }
}
