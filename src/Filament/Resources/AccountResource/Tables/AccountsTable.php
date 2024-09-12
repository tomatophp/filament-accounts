<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Tables;

use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;
use Maatwebsite\Excel\Facades\Excel;
use TomatoPHP\FilamentAccounts\Components\AccountColumn;
use TomatoPHP\FilamentAccounts\Export\ExportAccounts;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\AccountsTableActions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\ExportAccountsAction;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\ImportAccountsAction;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Filters\AccountsFilters;
use TomatoPHP\FilamentHelpers\Contracts\TableBuilder;
use TomatoPHP\FilamentTypes\Components\TypeColumn;

class AccountsTable extends TableBuilder
{
    public function table(Table $table): Table
    {
        $colums = collect([]);

        //Use Avatar
        if(filament('filament-accounts')->useAvatar) {
            $colums->push(
                AccountColumn::make('id')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.id')),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.name'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable()
            );
        }
        else {
            $colums->push(
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.name'))
                    ->toggleable()
                    ->sortable()
                    ->searchable()
            );
        }

        //Use Type Column
        if(filament('filament-accounts')->useTypes){
            $colums->push(
                TypeColumn::make('type')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.type'))
                    ->toggleable()
                    ->sortable()
                    ->searchable()
            );
        }
        else if(filament('filament-accounts')->showTypeField){
            $colums->push(
                Tables\Columns\TextColumn::make('type')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.type'))
                    ->toggleable()
                    ->sortable()
                    ->searchable()
            );
        }

        //Use Teams
        if(filament('filament-accounts')->useTeams){
            $colums->push(
                Tables\Columns\TextColumn::make('teams.name')
                    ->badge()
                    ->icon('heroicon-o-user-group')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.teams'))
                    ->toggleable()
                    ->searchable()
            );
        }

        //Default Columns
        $colums = $colums->merge([
            Tables\Columns\TextColumn::make('email')
                ->label(trans('filament-accounts::messages.accounts.coulmns.email'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('phone')
                ->label(trans('filament-accounts::messages.accounts.coulmns.phone'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->searchable()
        ]);

        //Can Login
        if(filament('filament-accounts')->canLogin){
            $colums->push(
                Tables\Columns\IconColumn::make('is_login')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.is_login'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->boolean()
            );
        }

        //Can Blocked
        if(filament('filament-accounts')->canBlocked) {
            $colums->push(
                Tables\Columns\IconColumn::make('is_active')
                    ->label(trans('filament-accounts::messages.accounts.coulmns.is_active'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->boolean()
            );
        }

        //Can Verified
        $colums = $colums->merge([
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
        ]);

        $actions = collect([]);
        if(filament('filament-accounts')->useExport){
            $actions->push(ExportAccountsAction::make());
        }
        if(filament('filament-accounts')->useImport){
            $actions->push(ImportAccountsAction::make());
        }
        return $table
            ->headerActions($actions->toArray())
            ->columns($colums->toArray())
            ->filters(config('filament-accounts.accounts.filters') ? config('filament-accounts.accounts.filters')::make() : AccountsFilters::make())
            ->actions(config('filament-accounts.accounts.actions') ? config('filament-accounts.accounts.actions')::make() : AccountsTableActions::make())
            ->defaultSort('id', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
}
