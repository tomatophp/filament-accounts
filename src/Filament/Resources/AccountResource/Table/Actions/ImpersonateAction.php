<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Actions;

use Filament\Facades\Filament;
use Filament\Support\Concerns\EvaluatesClosures;
use TomatoPHP\FilamentAccounts\Concerns\Impersonates;

class ImpersonateAction extends Action
{
    use EvaluatesClosures;
    use Impersonates;

    public static function make(): \Filament\Actions\Action
    {
        $plugin = filament('filament-accounts');
        (new self)->guard('accounts');
        (new self)->redirectTo($plugin->impersonateRedirect);
        (new self)->backTo(Filament::getCurrentOrDefaultPanel()->getUrl());

        return \Filament\Actions\Action::make('impersonate')
            ->iconButton()
            ->requiresConfirmation()
            ->icon('heroicon-o-user-circle')
            ->color('info')
            ->tooltip(trans('filament-accounts::messages.accounts.actions.impersonate'))
            ->label(trans('filament-accounts::messages.accounts.actions.impersonate'))
            ->action(fn ($record) => (new self)->impersonate($record))
            ->hidden(fn ($record) => ! (new self)->canBeImpersonated($record));
    }
}
