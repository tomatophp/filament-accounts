<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\AccountForm;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\AccountInfoList;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountTable;

class AccountResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static bool $softDelete = true;

    protected static ?int $navigationSort = 1;

    public static function getModel(): string
    {
        return config('filament-accounts.model');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-accounts::messages.group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-accounts::messages.accounts.label');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-accounts::messages.accounts.label');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-accounts::messages.accounts.single');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return config('filament-accounts.resource.infolist.class') ? config('filament-accounts.resource.infolist.class')::make($infolist) : AccountInfoList::make($infolist);
    }

    public static function form(Form $form): Form
    {
        return config('filament-accounts.resource.form.class') ? config('filament-accounts.resource.form.class')::make($form) : AccountForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return config('filament-accounts.resource.table.class') ? config('filament-accounts.resource.table.class')::make($table) : AccountTable::make($table);
    }

    public static function getRelations(): array
    {
        return FilamentAccounts::getRelations() ?? [];
    }

    public static function getPages(): array
    {
        return config('filament-accounts.simple') ? [
            'index' => Pages\ManageAccounts::route('/'),
        ] : [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
            'view' => Pages\ViewAccount::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
