<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources;

use Filament\Notifications\Notification;
use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Forms\AccountsForm;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\RelationManagers;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Releations\AccountReleations;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Tables\AccountsTable;
use TomatoPHP\FilamentAccounts\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Services\SendNotification;
use TomatoPHP\FilamentIcons\Components\IconPicker;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;
use function Laravel\Prompts\confirm;

class AccountResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static bool $softDelete = true;

    protected static ?int $navigationSort = 1;

    /**
     * @return string|null
     */
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

    public static function form(Form $form): Form
    {
        return config('filament-accounts.accounts.form') ? config('filament-accounts.accounts.form')::make($form) : AccountsForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return config('filament-accounts.accounts.table') ? config('filament-accounts.accounts.table')::make($table) : AccountsTable::make($table);
    }

    public static function getRelations(): array
    {
        return config('filament-accounts.relations') ? config('filament-accounts.relations')::get() :  AccountReleations::get();
    }

    public static function getPages(): array
    {
        return config('filament-accounts.accounts.pages') ? config('filament-accounts.accounts.pages')::routes() : [
            'index' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\ListAccounts::route('/'),
            'edit' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\EditAccount::route('/{record}/edit')
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
