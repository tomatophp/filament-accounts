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

class AccountLocationsManager extends RelationManager
{
    protected static string $relationship = 'locations';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('filament-accounts::messages.locations.label');
    }

    /**
     * @return string|null
     */
    public static function getLabel(): ?string
    {
        return trans('filament-accounts::messages.locations.label');
    }

    /**
     * @return string|null
     */
    public static function getModelLabel(): ?string
    {
        return trans('filament-accounts::messages.locations.label');
    }


    /**
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return trans('filament-accounts::messages.locations.label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('country_id')
                    ->label(trans('filament-locations::messages.location.form.country_id'))
                    ->options(function () {
                        return \TomatoPHP\FilamentLocations\Models\Country::all()->pluck('name', 'id')->toArray();
                    })
                    ->searchable()
                    ->live(),
                Select::make('city_id')
                    ->label(trans('filament-locations::messages.location.form.city_id'))
                    ->options(function (Get $get){
                        return \TomatoPHP\FilamentLocations\Models\City::where('country_id', $get('country_id'))
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->live(),
                Select::make('area_id')
                    ->label(trans('filament-locations::messages.location.form.area_id'))
                    ->options(function (Get $get){
                        return \TomatoPHP\FilamentLocations\Models\Area::where('city_id', $get('city_id'))
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable(),
                Forms\Components\TextInput::make('street')
                    ->label(trans('filament-locations::messages.location.form.street'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('home_number')
                    ->label(trans('filament-locations::messages.location.form.home_number'))
                    ->numeric(),
                Forms\Components\TextInput::make('flat_number')
                    ->label(trans('filament-locations::messages.location.form.flat_number'))
                    ->numeric(),
                Forms\Components\TextInput::make('floor_number')
                    ->label(trans('filament-locations::messages.location.form.floor_number'))
                    ->numeric(),
                Forms\Components\TextInput::make('mark')
                    ->label(trans('filament-locations::messages.location.form.mark'))
                    ->maxLength(255),
                Forms\Components\Textarea::make('map_url')
                    ->label(trans('filament-locations::messages.location.form.map_url'))
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('note')
                    ->label(trans('filament-locations::messages.location.form.note'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('lat')
                    ->label(trans('filament-locations::messages.location.form.lat'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('lng')
                    ->label(trans('filament-locations::messages.location.form.lng'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip')
                    ->label(trans('filament-locations::messages.location.form.zip'))
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_main')
                    ->label(trans('filament-locations::messages.location.form.is_main')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('area.name')
                    ->label(trans('filament-locations::messages.location.form.area_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label(trans('filament-locations::messages.location.form.city_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->label(trans('filament-locations::messages.location.form.country_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('street')
                    ->label(trans('filament-locations::messages.location.form.street'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_main')
                    ->label(trans('filament-locations::messages.location.form.is_main'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('filament-locations::messages.country.form.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('filament-locations::messages.country.form.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(trans('filament-accounts::messages.locations.create'))
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
