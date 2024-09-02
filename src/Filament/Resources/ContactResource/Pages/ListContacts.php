<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\ContactResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentAccounts\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContacts extends ManageRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('status')
                ->label('Manage Status')
                ->icon('heroicon-s-tag')
                ->url(ContactStatusTypes::getUrl()),
        ];
    }
}
