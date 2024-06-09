<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources;

use TomatoPHP\FilamentAccounts\Filament\Resources\ContactResource\Pages;
use TomatoPHP\FilamentAccounts\Filament\Resources\ContactResource\RelationManagers;
use TomatoPHP\FilamentAccounts\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-accounts::messages.group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-accounts::messages.contacts.label');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-accounts::messages.contacts.label');
    }
    public static function form(Form $form): Form
    {
        $fields = [];
        if(filament('filament-accounts')->useTypes) {
            $fields[] = Forms\Components\Select::make('status')
                ->label(trans('filament-accounts::messages.contacts.columns.status'))
                ->columnSpan(2)
                ->searchable()
                ->options(Type::where('for', 'contacts')->where('type', 'status')->pluck('name', 'key')->toArray())
                ->default('pending');
        }
        else {
            $fields[] = Forms\Components\TextInput::make('status')
                ->label(trans('filament-accounts::messages.contacts.columns.status'))
                ->columnSpan(2)
                ->default('pending');
        }
        return $form
            ->schema(array_merge($fields,[

                Forms\Components\TextInput::make('subject')
                    ->label(trans('filament-accounts::messages.contacts.columns.subject'))
                    ->disabled()
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->label(trans('filament-accounts::messages.contacts.columns.message'))
                    ->disabled()
                    ->columnSpan(2)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('active')
                    ->label(trans('filament-accounts::messages.contacts.columns.active')),
            ]));
    }

    public static function table(Table $table): Table
    {
        $columns = [];
        if(filament('filament-accounts')->useTypes) {
            $columns[] = TypeColumn::make('status')
                ->label(trans('filament-accounts::messages.contacts.columns.status'))
                ->searchable();
        }
        else {
            $columns[] = Tables\Columns\TextColumn::make('status')
                ->label(trans('filament-accounts::messages.contacts.columns.status'))
                ->searchable();
        }
        return $table
            ->columns(array_merge($columns, [
                Tables\Columns\TextColumn::make('type')
                    ->label(trans('filament-accounts::messages.contacts.columns.type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-accounts::messages.contacts.columns.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(trans('filament-accounts::messages.contacts.columns.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans('filament-accounts::messages.contacts.columns.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label(trans('filament-accounts::messages.contacts.columns.subject'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->label(trans('filament-accounts::messages.contacts.columns.active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]))
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListContacts::route('/'),
        ];
    }
}
