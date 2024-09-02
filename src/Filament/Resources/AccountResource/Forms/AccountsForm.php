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
        $components = collect([]);

        if(filament('filament-accounts')->useAvatar) {
            $components->push(
                Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                    ->alignCenter()
                    ->collection('avatar')
                    ->avatar()
                    ->columnSpan(2)
                    ->hiddenLabel()
                    ->label(trans('filament-accounts::messages.accounts.coulmns.avatar'))
            );
        }

        $components->push(
            Forms\Components\TextInput::make('name')
                ->label(trans('filament-accounts::messages.accounts.coulmns.name'))
                ->columnSpan(2)
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->label(trans('filament-accounts::messages.accounts.coulmns.email'))
                ->required(fn(Forms\Get $get) => $get('loginBy') === 'email')
                ->email()
                ->maxLength(255),
            Forms\Components\TextInput::make('phone')
                ->label(trans('filament-accounts::messages.accounts.coulmns.phone'))
                ->required(fn(Forms\Get $get) => $get('loginBy') === 'phone')
                ->tel()
                ->maxLength(255)
        );

        if(filament('filament-accounts')->showAddressField) {
            $components->push(
                Forms\Components\Textarea::make('address')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.address'))
                    ->columnSpanFull()
            );
        }
        if(filament('filament-accounts')->useTypes) {
            $components->push(
                Forms\Components\Select::make('type')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.type'))
                    ->searchable()
                    ->required()
                    ->options(Type::query()->where('for', 'accounts')->where('type', 'type')->pluck('name', 'key')->toArray())
                    ->default('account')
            );
        }
        else if(filament('filament-accounts')->showTypeField) {
            $components->push(
                Forms\Components\TextInput::make('type')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.type'))
                    ->required()
                    ->default('account')
            );
        }
        if(filament('filament-accounts')->useLoginBy) {
            $components->push(
                Forms\Components\Select::make('loginBy')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.loginBy'))
                    ->searchable()
                    ->options([
                        'email' => trans('filament-accounts::messages.accounts.coulmns.email'),
                        'phone' => trans('filament-accounts::messages.accounts.coulmns.phone')
                    ])
                    ->required()
                    ->default('email')
            );
        }
        if(filament('filament-accounts')->canBlocked) {
            $components->push(
                Forms\Components\Toggle::make('is_active')
                    ->columnSpan(2)
                    ->label(trans('filament-accounts::messages.accounts.coulmns.is_active'))
                    ->default(false)
                    ->required()
            );
        }
        if(filament('filament-accounts')->canLogin) {
            $components = $components->merge([
                Forms\Components\Toggle::make('is_login')->default(false)
                    ->columnSpan(2)
                    ->label(trans('filament-accounts::messages.accounts.coulmns.is_login'))
                    ->live(),
                Forms\Components\TextInput::make('password')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.password'))
                    ->confirmed()
                    ->hidden(fn(Forms\Get $get) => !$get('is_login') || $get('id') !== null)
                    ->password()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password_confirmation')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.password_confirmation'))
                    ->hidden(fn(Forms\Get $get) => !$get('is_login') || $get('id') !== null)
                    ->password()
                    ->maxLength(255),
            ]);
        }

        return $form->schema($components->toArray());
    }
}
