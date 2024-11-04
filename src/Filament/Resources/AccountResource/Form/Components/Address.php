<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class Address extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\Textarea::make('address')
            ->label(trans('filament-accounts::messages.accounts.columns.address'))
            ->columnSpanFull();
    }
}
