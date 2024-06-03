<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Forms;

use Filament\Forms\Form;
use Filament\Forms;
use TomatoPHP\FilamentHelpers\Contracts\FormBuilder;
use TomatoPHP\FilamentTypes\Models\Type;

class AccountsForm extends FormBuilder
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                ->collection('avatar')
                ->columnSpan(2)
                ->label(trans('filament-accounts::messages.accounts.coulmns.avatar')),
            Forms\Components\TextInput::make('name')
                ->label(trans('filament-accounts::messages.accounts.coulmns.name'))
                ->columnSpan(2)
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('type')
                ->label(trans('filament-accounts::messages.accounts.coulmns.type'))
                ->searchable()
                ->required()
                ->options(Type::query()->where('for', 'accounts')->where('type', 'type')->pluck('name', 'key')->toArray())
                ->default('account'),
            Forms\Components\Select::make('loginBy')
                ->label(trans('filament-accounts::messages.accounts.coulmns.loginBy'))
                ->searchable()
                ->options([
                    'email' => trans('filament-accounts::messages.accounts.coulmns.email'),
                    'phone' => trans('filament-accounts::messages.accounts.coulmns.phone')
                ])
                ->required()
                ->default('email'),
            Forms\Components\TextInput::make('email')
                ->label(trans('filament-accounts::messages.accounts.coulmns.email'))
                ->required(fn(Forms\Get $get) => $get('loginBy') === 'email')
                ->email()
                ->maxLength(255),
            Forms\Components\TextInput::make('phone')
                ->label(trans('filament-accounts::messages.accounts.coulmns.phone'))
                ->required(fn(Forms\Get $get) => $get('loginBy') === 'phone')
                ->tel()
                ->maxLength(255),
            Forms\Components\Textarea::make('address')
                ->label(trans('filament-accounts::messages.accounts.coulmns.address'))
                ->columnSpanFull(),
            Forms\Components\Toggle::make('is_login')->default(false)
                ->columnSpan(2)
                ->label(trans('filament-accounts::messages.accounts.coulmns.is_login'))
                ->live(),
            Forms\Components\TextInput::make('password')
                ->label(trans('filament-accounts::messages.accounts.coulmns.password'))
                ->confirmed()
                ->hidden(fn(Forms\Get $get) => !$get('is_login'))
                ->password()
                ->maxLength(255),
            Forms\Components\TextInput::make('password_confirmation')
                ->label(trans('filament-accounts::messages.accounts.coulmns.password_confirmation'))
                ->hidden(fn(Forms\Get $get) => !$get('is_login'))
                ->password()
                ->maxLength(255),
            Forms\Components\Toggle::make('is_active')
                ->columnSpan(2)
                ->label(trans('filament-accounts::messages.accounts.coulmns.is_active'))
                ->default(false)
                ->required()
        ]);
    }
}
