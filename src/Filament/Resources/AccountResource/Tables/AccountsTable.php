<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Tables;

use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;
use TomatoPHP\FilamentAccounts\Components\AccountColumn;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\AccountsActions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Filters\AccountsFilters;
use TomatoPHP\FilamentHelpers\Contracts\TableBuilder;
use TomatoPHP\FilamentTypes\Components\TypeColumn;

class AccountsTable extends TableBuilder
{
    public function table(Table $table): Table
    {
        $colums = [];
        if(filament('filament-accounts')->useAvatar) {
            $colums[] = AccountColumn::make('id')
                ->label(trans('filament-accounts::messages.accounts.coulmns.id'));

            $colums[] = Tables\Columns\TextColumn::make('name')
                ->label(trans('filament-accounts::messages.accounts.coulmns.name'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->searchable();
        }
        else {
            $colums[] = Tables\Columns\TextColumn::make('name')
                ->label(trans('filament-accounts::messages.accounts.coulmns.name'))
                ->toggleable()
                ->sortable()
                ->searchable();
        }

        if(filament('filament-accounts')->useTypes){
            $colums[] = TypeColumn::make('type')
                ->label(trans('filament-accounts::messages.accounts.coulmns.type'))
                ->toggleable()
                ->sortable()
                ->searchable();
        }

        if(filament('filament-accounts')->useTeams){
            $colums[] = Tables\Columns\TextColumn::make('teams.name')
                ->badge()
                ->icon('heroicon-o-user-group')
                ->label(trans('filament-accounts::messages.accounts.coulmns.teams'))
                ->toggleable()
                ->searchable();
        }


        $colums = array_merge($colums, [
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

        if(filament('filament-accounts')->canLogin){
            $colums[] = Tables\Columns\IconColumn::make('is_login')
                ->label(trans('filament-accounts::messages.accounts.coulmns.is_login'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->boolean();
        }

        if(filament('filament-accounts')->canBlocked) {
            $colums[] = Tables\Columns\IconColumn::make('is_active')
                ->label(trans('filament-accounts::messages.accounts.coulmns.is_active'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->boolean();
        }

        if(filament('filament-accounts')->useTeams){
            $colums[] = Tables\Columns\TextColumn::make('teams.name')
                ->badge()
                ->icon('heroicon-o-user-group')
                ->label(trans('filament-accounts::messages.accounts.coulmns.teams'))
                ->toggleable()
                ->searchable();
        }

        $colums = array_merge($colums, [
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
        return $table
            ->columns($colums)
            ->filters(config('filament-accounts.accounts.filters')? config('filament-accounts.accounts.filters')::make() : AccountsFilters::make())
            ->actions(config('filament-accounts.accounts.actions')? config('filament-accounts.accounts.actions')::make() : AccountsActions::make())
            ->defaultSort('id', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
