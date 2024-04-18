<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources;

use Filament\Notifications\Notification;
use Guava\FilamentIconPicker\Forms\IconPicker;
use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\RelationManagers;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->searchable()
                    ->required()
                    ->options(Type::query()->where('for', 'accounts')->where('type', 'types')->pluck('name', 'key')->toArray())
                    ->default('account'),
                Forms\Components\Select::make('loginBy')
                    ->searchable()
                    ->options([
                        'email' => 'Email',
                        'phone' => 'Phone'
                    ])
                    ->required()
                    ->default('email'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_login')->default(false)->live(),
                Forms\Components\TextInput::make('password')
                    ->columnSpan(2)
                    ->hidden(fn(Forms\Get $get) => !$get('is_login'))
                    ->password()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->default(false)
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TypeColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_login')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
               Tables\Filters\TrashedFilter::make(),
               Tables\Filters\SelectFilter::make('type')
                    ->searchable()
                    ->options(Type::query()->where('for', 'accounts')->where('type', 'types')->pluck('name', 'key')->toArray())
            ])
            ->actions(array_merge(FilamentAccounts::loadActions(), [
                Tables\Actions\Action::make('password')
                    ->icon('heroicon-s-lock-closed')
                    ->iconButton()
                    ->tooltip('Change Password')
                    ->color('danger')
                    ->form(function (Account $account) {
                        return [
                            Forms\Components\TextInput::make('password')
                                ->password()
                                ->required()
                                ->confirmed()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('password_confirmation')
                                ->password()
                                ->required()
                                ->maxLength(255),
                        ];
                    })
                    ->action(function (Account $account){
                        $account->update([
                            'password' => bcrypt(request()->password)
                        ]);

                        Notification::make()
                            ->title('Account Password Changed')
                            ->body('Account password changed successfully')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('notify')
                    ->icon('heroicon-s-bell')
                    ->iconButton()
                    ->tooltip('Notify Account')
                    ->color('info')
                    ->form(function (Account $account) {
                        return [
                            Forms\Components\Toggle::make('use_notification_template')
                                ->default(true)
                                ->live()
                                ->required(),
                            Forms\Components\Select::make('template_id')
                                ->hidden(fn (Forms\Get $get) => !$get('use_notification_template'))
                                ->searchable()
                                ->validationAttribute('template_id','required|exists:notifications_templates,id')
                                ->label(trans('filament-alerts::messages.notifications.form.template'))
                                ->options(
                                    NotificationsTemplate::pluck('name', 'id')->toArray()
                                )
                                ->required(),
                            Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                                ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                                ->collection('images')
                                ->image(),
                            Forms\Components\TextInput::make('title')
                                ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                                ->label(trans('filament-alerts::messages.templates.form.title'))
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Textarea::make('body')
                                ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                                ->label(trans('filament-alerts::messages.templates.form.body'))
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('url')
                                ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                                ->label(trans('filament-alerts::messages.templates.form.url'))
                                ->url()
                                ->maxLength(255),
                            IconPicker::make('icon')
                                ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                                ->label(trans('filament-alerts::messages.templates.form.icon'))
                                ->default('heroicon-o-check-circle'),
                            Forms\Components\Select::make('type')
                                ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                                ->label(trans('filament-alerts::messages.templates.form.type'))
                                ->options(collect(config('filament-alerts.types'))->pluck('name', 'id')->toArray())
                                ->default('success'),
                            Forms\Components\Select::make('providers')
                                ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                                ->label(trans('filament-alerts::messages.templates.form.providers'))
                                ->multiple()
                                ->options(collect(config('filament-alerts.providers'))->pluck('name', 'id')->toArray()),
                        ];
                    })
                    ->action(function (Account $account, array $data){
                        if($data['use_notification_template']){
                            $template = NotificationsTemplate::find($data['template_id']);
                            if($template){
                                SendNotification::make($template->providers)
                                    ->title($template->title)
                                    ->template($template->key)
                                    ->database(in_array('database', $template->providers))
                                    ->privacy('private')
                                    ->model(config('filament-accounts.model'))
                                    ->id($account->id)
                                    ->fire();
                            }
                            else {
                                SendNotification::make($data['providers'])
                                    ->title($data['title'])
                                    ->message($data['message'])
                                    ->icon($data['icon'])
                                    ->image($data['image'])
                                    ->url($data['url'])
                                    ->database(in_array('database', $data['providers']))
                                    ->privacy('private')
                                    ->model(config('filament-accounts.model'))
                                    ->id($account->id)
                                    ->fire();
                            }

                            Notification::make()
                                ->title('Notification Sent')
                                ->body('Notification sent successfully')
                                ->success()
                                ->send();
                        }
                    }),
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Delete'),
                Tables\Actions\ForceDeleteAction::make()
                    ->iconButton()
                    ->tooltip('Force Delete'),
                Tables\Actions\RestoreAction::make()
                    ->iconButton()
                    ->tooltip('Restore')
            ]))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        $loadRelations = FilamentAccounts::loadRelations();

        return array_merge([
            RelationManagers\AccountMetaManager::make(),
            RelationManagers\AccountLocationsManager::make(),
            RelationManagers\AccountRequestsManager::make(),
        ], $loadRelations);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
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
