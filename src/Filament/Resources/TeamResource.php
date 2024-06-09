<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources;

use TomatoPHP\FilamentAccounts\Filament\Resources\TeamResource\Pages;
use TomatoPHP\FilamentAccounts\Filament\Resources\TeamResource\RelationManagers;
use TomatoPHP\FilamentAccounts\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getLabel(): ?string
    {
        return trans('filament-accounts::messages.team.single');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-accounts::messages.team.title');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-accounts::messages.team.title');
    }


    public static function getNavigationGroup(): ?string
    {
        return trans('filament-accounts::messages.group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                    ->label(trans('filament-accounts::messages.team.columns.avatar'))
                    ->collection('avatar')
                    ->image(),
                Forms\Components\Select::make('account_id')
                    ->label(trans('filament-accounts::messages.team.columns.owner'))
                    ->relationship('owner', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label(trans('filament-accounts::messages.team.columns.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('personal_team')
                    ->label(trans('filament-accounts::messages.team.columns.personal_team'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->collection('avatar')
                    ->label(trans('filament-accounts::messages.team.columns.avatar')),
                Tables\Columns\TextColumn::make('owner.name')
                    ->label(trans('filament-accounts::messages.team.columns.owner'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-accounts::messages.team.columns.name'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('personal_team')
                    ->label(trans('filament-accounts::messages.team.columns.personal_team'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
