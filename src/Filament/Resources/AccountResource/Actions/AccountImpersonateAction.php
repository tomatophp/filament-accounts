<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions;

use Filament\Tables\Actions\Action;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class AccountImpersonateAction
{
    public static function make(): Action
    {
        return Impersonate::make('impersonate')
            ->guard('accounts')
            ->color('info')
            ->tooltip(trans('filament-accounts::messages.accounts.actions.impersonate'))
            ->redirectTo( config('filament-accounts.features.impersonate.redirect'));
    }
}
