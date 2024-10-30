<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Actions;

use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class ImpersonateAction extends Action
{
    public static function make(): \Filament\Tables\Actions\Action
    {
        if (class_exists("STS\FilamentImpersonate\Tables\Actions\Impersonate")) {
            return Impersonate::make('impersonate')
                ->guard('accounts')
                ->color('info')
                ->tooltip(trans('filament-accounts::messages.accounts.actions.impersonate'))
                ->redirectTo(config('filament-accounts.features.impersonate.redirect'));
        } else {
            return \Filament\Tables\Actions\Action::make('impersonate');
        }

    }
}
