<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Tables;

use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\AccountsActions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Filters\AccountsFilters;
use TomatoPHP\FilamentHelpers\Contracts\TableBuilder;
use TomatoPHP\FilamentTypes\Components\TypeColumn;

class AccountsTable extends TableBuilder
{
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TypeColumn::make('type')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.type'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.email'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.phone'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_login')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.is_login'))
                    ->sortable()
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.is_active'))
                    ->sortable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->sortable()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(config('filament-accounts.accounts.filters')? config('filament-accounts.accounts.filters')::make() : AccountsFilters::make())
            ->actions(config('filament-accounts.accounts.actions')? config('filament-accounts.accounts.actions')::make() : AccountsActions::make())
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
