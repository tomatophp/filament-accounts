<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class IsActive extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\Toggle::make('is_active')
            ->columnSpan(2)
            ->label(trans('filament-accounts::messages.accounts.columns.is_active'))
            ->default(false)
            ->required();
    }
}
