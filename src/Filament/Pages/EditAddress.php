<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use TomatoPHP\FilamentLocations\Models\Location;

class EditAddress extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static string $view = 'filament-accounts::pages.edit-address';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return  trans('filament-accounts::messages.address.title');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-accounts::messages.address.title'); // TODO: Change the autogenerated stub
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Location::query()->where('model_id', auth('accounts')->user()->id)->where('model_type',config('filament-accounts.model')))
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
                    ->form($this->getLocationForm())
                    ->using(function (array $data) {
                        return auth('accounts')->user()->locations()->create($data);
                    })
                    ->label(trans('filament-accounts::messages.locations.create'))
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make()->form($this->getLocationForm()),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getLocationForm(): array
    {
        return [
            Forms\Components\Grid::make([
                "lg" => 4,
                "md" => 4,
                "sm" => 1,
            ])->schema([
                Select::make('country_id')
                    ->label(trans('filament-locations::messages.location.form.country_id'))
                    ->options(function () {
                        return \TomatoPHP\FilamentLocations\Models\Country::all()->pluck('name', 'id')->toArray();
                    })
                    ->searchable()
                    ->columnSpanFull()
                    ->required()
                    ->live(),
                Select::make('city_id')
                    ->label(trans('filament-locations::messages.location.form.city_id'))
                    ->options(function (Get $get){
                        return \TomatoPHP\FilamentLocations\Models\City::where('country_id', $get('country_id'))
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->required()
                    ->searchable()
                    ->columnSpan(2)
                    ->live(),
                Select::make('area_id')
                    ->label(trans('filament-locations::messages.location.form.area_id'))
                    ->options(function (Get $get){
                        return \TomatoPHP\FilamentLocations\Models\Area::where('city_id', $get('city_id'))
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->required()
                    ->columnSpan(2)
                    ->searchable(),
                Forms\Components\TextInput::make('street')
                    ->columnSpanFull()
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
                Forms\Components\TextInput::make('zip')
                    ->label(trans('filament-locations::messages.location.form.zip'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('mark')
                    ->columnSpanFull()
                    ->label(trans('filament-locations::messages.location.form.mark'))
                    ->maxLength(255),
                Forms\Components\Textarea::make('map_url')
                    ->label(trans('filament-locations::messages.location.form.map_url'))
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('lat')
                    ->label(trans('filament-locations::messages.location.form.lat'))
                    ->columnSpan(2)
                    ->maxLength(255),
                Forms\Components\TextInput::make('lng')
                    ->label(trans('filament-locations::messages.location.form.lng'))
                    ->columnSpan(2)
                    ->maxLength(255),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull()
                    ->label(trans('filament-locations::messages.location.form.note'))
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_main')
                    ->columnSpanFull()
                    ->label(trans('filament-locations::messages.location.form.is_main')),
            ])
        ];
    }
}