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
        return "Meta";
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Key')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('key')
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('value'),
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
