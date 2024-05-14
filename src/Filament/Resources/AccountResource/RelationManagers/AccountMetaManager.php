<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountMetaManager extends RelationManager
{
    protected static string $relationship = 'accountsMetas';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('filament-accounts::messages.meta.label');
    }

    /**
     * @return string|null
     */
    public static function getLabel(): ?string
    {
        return trans('filament-accounts::messages.meta.label');
    }

    /**
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return trans('filament-accounts::messages.meta.label');
    }

    /**
     * @return string|null
     */
    public static function getModelLabel(): ?string
    {
        return trans('filament-accounts::messages.meta.label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label(trans('filament-accounts::messages.meta.columns.key'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value')
                    ->label(trans('filament-accounts::messages.meta.columns.value'))
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label(trans('filament-accounts::messages.meta.columns.key'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label(trans('filament-accounts::messages.meta.columns.value'))
                    ->view('filament-accounts::table-columns.value')
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
