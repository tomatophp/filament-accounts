<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class Type extends Component
{
    public static function make(): Forms\Components\Field
    {
        if (class_exists('TomatoPHP\FilamentTypes\Models\Type')) {
            return Forms\Components\Select::make('type')
                ->columnSpanFull()
                ->label(trans('filament-accounts::messages.accounts.columns.type'))
                ->searchable()
                ->required()
                ->options(\TomatoPHP\FilamentTypes\Models\Type::query()->where('for', 'accounts')->where('type', 'type')->pluck('name', 'key')->toArray())
                ->default('account');
        } else {
            return Forms\Components\TextInput::make('type')
                ->columnSpanFull()
                ->label(trans('filament-accounts::messages.accounts.columns.type'))
                ->required()
                ->default('account');
        }

    }
}
