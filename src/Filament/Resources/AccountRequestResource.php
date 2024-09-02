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
        $columns = [];
        if(filament('filament-accounts')->useTypes){
            $columns[] = Forms\Components\Select::make('type')
                ->label(trans('filament-accounts::messages.requests.columns.type'))
                ->searchable()
                ->options(Type::where('for', 'account-requests')->where('type', 'types')->get()->pluck('name', 'key')->toArray());

            $columns[] = Forms\Components\Select::make('status')
                ->label(trans('filament-accounts::messages.requests.columns.status'))
                ->searchable()
                ->options(Type::where('for', 'account-requests')->where('type', 'status')->get()->pluck('name', 'key')->toArray())
                ->default('pending');
        }
        else {
            $columns[] = Forms\Components\TextInput::make('type')
                ->label(trans('filament-accounts::messages.requests.columns.type'))
                ->default('contact');

            $columns[] = Forms\Components\TextInput::make('status')
                ->label(trans('filament-accounts::messages.requests.columns.status'))
                ->default('pending');
        }
        $columns[] = Forms\Components\Toggle::make('is_approved')
            ->label(trans('filament-accounts::messages.requests.columns.is_approved'));

        return $form->schema($columns);
    }

    public static function table(Table $table): Table
    {
        $columns = [];

        if(filament('filament-accounts')->useAvatar){
            $columns[] = AccountColumn::make('account.id')
                ->label(trans('filament-accounts::messages.requests.columns.account'))
                ->sortable();
        }
        else {
            $columns[] = Tables\Columns\TextColumn::make('account.name');
        }

        $columns[] = Tables\Columns\TextColumn::make('user.name')
            ->label(trans('filament-accounts::messages.requests.columns.user'))
            ->sortable();

        if(filament('filament-accounts')->useTypes){
            $columns[] =TypeColumn::make('type')
                ->label(trans('filament-accounts::messages.requests.columns.type'))
                ->searchable();
            $columns[] = TypeColumn::make('status')
                    ->label(trans('filament-accounts::messages.requests.columns.status'))
                    ->searchable();
        }
        else {
            $columns[] =Tables\Columns\TextColumn::make('type')
                ->label(trans('filament-accounts::messages.requests.columns.type'))
                ->searchable();
            $columns[] = Tables\Columns\TextColumn::make('status')
                ->label(trans('filament-accounts::messages.requests.columns.status'))
                ->searchable();
        }


        $columns = array_merge($columns, [
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
        ]);

        return $table
            ->columns($columns)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
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
