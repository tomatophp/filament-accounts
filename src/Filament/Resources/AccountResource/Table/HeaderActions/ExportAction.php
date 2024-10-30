<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\HeaderActions;

use Filament\Forms;
use Maatwebsite\Excel\Facades\Excel;
use TomatoPHP\FilamentAccounts\Export\ExportAccounts;

class ExportAction extends Action
{
    public static function make(): \Filament\Tables\Actions\Action
    {
        return \Filament\Tables\Actions\Action::make('export')
            ->label(trans('filament-accounts::messages.accounts.export.title'))
            ->requiresConfirmation()
            ->color('info')
            ->icon('heroicon-o-arrow-down-on-square')
            ->fillForm([
                'columns' => [
                    'id' => trans('filament-accounts::messages.accounts.columns.id'),
                    'name' => trans('filament-accounts::messages.accounts.columns.name'),
                    'email' => trans('filament-accounts::messages.accounts.columns.email'),
                    'phone' => trans('filament-accounts::messages.accounts.columns.phone'),
                    'address' => trans('filament-accounts::messages.accounts.columns.address'),
                    'type' => trans('filament-accounts::messages.accounts.columns.type'),
                    'is_login' => trans('filament-accounts::messages.accounts.columns.is_login'),
                    'is_active' => trans('filament-accounts::messages.accounts.columns.is_active'),
                    'created_at' => trans('filament-accounts::messages.accounts.columns.created_at'),
                    'updated_at' => trans('filament-accounts::messages.accounts.columns.updated_at'),
                ],
            ])
            ->form([
                Forms\Components\KeyValue::make('columns')
                    ->label(trans('filament-accounts::messages.accounts.export.columns'))
                    ->required()
                    ->editableKeys(false)
                    ->addable(false),
            ])
            ->action(function (array $data) {
                return Excel::download(new ExportAccounts($data), 'accounts.csv');
            });
    }
}
