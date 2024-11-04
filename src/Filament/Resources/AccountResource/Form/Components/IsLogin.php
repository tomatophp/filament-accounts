<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class IsLogin extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\Toggle::make('is_login')->default(false)
            ->columnSpan(2)
            ->label(trans('filament-accounts::messages.accounts.columns.is_login'))
            ->live();
    }
}
