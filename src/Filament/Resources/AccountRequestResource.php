<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources;

use TomatoPHP\FilamentAccounts\Components\AccountColumn;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource\Pages;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource\RelationManagers;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\EditAccount;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\RelationManagers\AccountRequestMetaManager;
use TomatoPHP\FilamentAccounts\Models\AccountRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class AccountRequestResource extends Resource
{
    protected static ?string $model = AccountRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-accounts::messages.group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-accounts::messages.requests.label');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-accounts::messages.requests.label');
    }

    public static function form(Form $form): Form
    {
        $payload = [];
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label(trans('filament-accounts::messages.requests.columns.type'))
                    ->searchable()
                    ->options(Type::where('for', 'contacts')->where('type', 'type')->get()->pluck('name', 'key')->toArray()),
                Forms\Components\Select::make('status')
                    ->label(trans('filament-accounts::messages.requests.columns.status'))
                    ->searchable()
                    ->options(Type::where('for', 'contacts')->where('type', 'status')->get()->pluck('name', 'key')->toArray())
                    ->default('pending'),

                Forms\Components\Toggle::make('is_approved')
                    ->label(trans('filament-accounts::messages.requests.columns.is_approved')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                AccountColumn::make('account.id')
                    ->label(trans('filament-accounts::messages.requests.columns.account'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(trans('filament-accounts::messages.requests.columns.user'))
                    ->sortable(),
                TypeColumn::make('type')
                    ->label(trans('filament-accounts::messages.requests.columns.type'))
                    ->searchable(),
                TypeColumn::make('status')
                    ->label(trans('filament-accounts::messages.requests.columns.status'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->label(trans('filament-accounts::messages.requests.columns.is_approved'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('is_approved_at')
                    ->label(trans('filament-accounts::messages.requests.columns.is_approved_at'))
                    ->dateTime()
                    ->sortable(),
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
            RelationManagers\AccountRequestMetaManager::make()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccountRequests::route('/'),
            'edit' => Pages\EditAccountRequest::route('/{record}/edit'),
        ];
    }
}
