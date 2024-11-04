<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\HeaderActions;

use Filament\Forms;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use TomatoPHP\FilamentAccounts\Import\ImportAccounts;

class ImportAction extends Action
{
    public static function make(): \Filament\Tables\Actions\Action
    {
        return \Filament\Tables\Actions\Action::make('import')
            ->label(trans('filament-accounts::messages.accounts.import.title'))
            ->form([
                Forms\Components\FileUpload::make('excel')
                    ->hint(trans('filament-accounts::messages.accounts.import.hint'))
                    ->label(trans('filament-accounts::messages.accounts.import.excel'))
                    ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel'])
                    ->required(),
            ])
            ->action(function (array $data) {
                try {
                    Excel::import(new ImportAccounts, storage_path('app/public/' . $data['excel']));

                    Notification::make()
                        ->title(trans('filament-accounts::messages.accounts.import.success'))
                        ->body(trans('filament-accounts::messages.accounts.import.body'))
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->title(trans('filament-accounts::messages.accounts.import.error'))
                        ->body(trans('filament-accounts::messages.accounts.import.error-body'))
                        ->danger()
                        ->send();
                }

            })
            ->color('warning')
            ->icon('heroicon-o-arrow-up-on-square');
    }
}
