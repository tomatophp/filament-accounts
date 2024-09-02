<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountRequests extends ManageRecords
{
    protected static string $resource = AccountRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ActionGroup::make([
                Actions\Action::make('status')
                    ->label(RequestsStatus::getNavigationLabel())
                    ->url(RequestsStatus::getUrl()),
                Actions\Action::make('type')
                    ->label(RequestsTypes::getNavigationLabel())
                    ->url(RequestsTypes::getUrl()),
            ])
            ->button()
            ->label(trans('filament-accounts::messages.account-requests.button'))
            ->icon('heroicon-s-cog')
        ];
    }
}
