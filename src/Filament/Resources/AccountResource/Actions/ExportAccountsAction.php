<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions;

use Filament\Tables\Actions\Action;
use Filament\Forms;
use Maatwebsite\Excel\Facades\Excel;
use TomatoPHP\FilamentAccounts\Export\ExportAccounts;

class ExportAccountsAction
{
    public static function make(): Action
    {
        return Action::make('export')
            ->label(trans('filament-accounts::messages.accounts.export.title'))
            ->requiresConfirmation()
            ->color('info')
            ->icon('heroicon-o-arrow-down-on-square')
            ->fillForm([
                'columns' => [
                    'id' => trans('filament-accounts::messages.accounts.coulmns.id'),
                    'name' => trans('filament-accounts::messages.accounts.coulmns.name'),
                    'email' => trans('filament-accounts::messages.accounts.coulmns.email'),
                    'phone' => trans('filament-accounts::messages.accounts.coulmns.phone'),
                    'address' => trans('filament-accounts::messages.accounts.coulmns.address'),
                    'type' => trans('filament-accounts::messages.accounts.coulmns.type'),
                    'is_login' => trans('filament-accounts::messages.accounts.coulmns.is_login'),
                    'is_active' => trans('filament-accounts::messages.accounts.coulmns.is_active'),
                    'created_at' => trans('filament-accounts::messages.accounts.coulmns.created_at'),
                    'updated_at' => trans('filament-accounts::messages.accounts.coulmns.updated_at'),
                ]
            ])
            ->form([
                Forms\Components\KeyValue::make('columns')
                    ->label(trans('filament-accounts::messages.accounts.export.columns'))
                    ->required()
                    ->editableKeys(false)
                    ->addable(false)
            ])
            ->action(function (array $data){
                return Excel::download(new ExportAccounts($data), 'accounts.csv');
            });
    }
}
