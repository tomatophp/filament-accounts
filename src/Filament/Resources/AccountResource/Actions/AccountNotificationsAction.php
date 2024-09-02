<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions;

use Filament\Notifications\Notification;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use TomatoPHP\FilamentIcons\Components\IconPicker;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Services\SendNotification;

class AccountNotificationsAction
{
    public static function make(): Action
    {
        return Action::make('notify')
            ->label(trans('filament-accounts::messages.accounts.actions.notifications'))
            ->icon('heroicon-s-bell')
            ->iconButton()
            ->tooltip(trans('filament-accounts::messages.accounts.actions.notifications'))
            ->color('info')
            ->form(function ($record) {
                return [
                    Forms\Components\Toggle::make('use_notification_template')
                        ->label(trans('filament-accounts::messages.accounts.notifications.use_notification_template'))
                        ->default(true)
                        ->live()
                        ->required(),
                    Forms\Components\Select::make('template_id')
                        ->label(trans('filament-accounts::messages.accounts.notifications.template_id'))
                        ->hidden(fn (Forms\Get $get) => !$get('use_notification_template'))
                        ->searchable()
                        ->validationAttribute('template_id','required|exists:notifications_templates,id')
                        ->label(trans('filament-alerts::messages.notifications.form.template'))
                        ->options(
                            NotificationsTemplate::pluck('name', 'id')->toArray()
                        )
                        ->createOptionForm([
                            Forms\Components\Grid::make(['default' => 3])
                                ->schema([
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                                        ->label(trans('filament-alerts::messages.templates.form.image'))
                                        ->collection('image')
                                        ->maxFiles(1)
                                        ->maxWidth(1024)
                                        ->acceptedFileTypes(['image/*'])
                                        ->columnSpan(3),
                                    Forms\Components\TextInput::make('name')
                                        ->label(trans('filament-alerts::messages.templates.form.name'))
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('key')
                                        ->label(trans('filament-alerts::messages.templates.form.key'))
                                        ->unique(table:'notifications_templates', column: 'key', ignoreRecord:true)
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('title')
                                        ->label(trans('filament-alerts::messages.templates.form.title'))
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\Textarea::make('body')
                                        ->label(trans('filament-alerts::messages.templates.form.body'))
                                        ->columnSpanFull(),
                                    Forms\Components\TextInput::make('url')
                                        ->label(trans('filament-alerts::messages.templates.form.url'))
                                        ->columnSpan(3)
                                        ->url()
                                        ->maxLength(255),
                                    IconPicker::make('icon')
                                        ->label(trans('filament-alerts::messages.templates.form.icon'))
                                        ->columnSpan(3)
                                        ->default('heroicon-o-check-circle'),
                                    Forms\Components\Select::make('type')
                                        ->label(trans('filament-alerts::messages.templates.form.type'))
                                        ->options(collect(config('filament-alerts.types'))->pluck('name', 'id')->toArray())
                                        ->default('success'),
                                    Forms\Components\Select::make('providers')
                                        ->label(trans('filament-alerts::messages.templates.form.providers'))
                                        ->multiple()
                                        ->options(collect(config('filament-alerts.providers'))->pluck('name', 'id')->toArray()),
                                ])
                        ])
                        ->createOptionUsing(function ($data) {
                            $record = NotificationsTemplate::create($data);
                            return $record->id;
                        })

                        ->required(),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                        ->label(trans('filament-accounts::messages.accounts.notifications.image'))
                        ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                        ->collection('images')
                        ->image(),
                    Forms\Components\TextInput::make('title')
                        ->label(trans('filament-accounts::messages.accounts.notifications.title'))
                        ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                        ->label(trans('filament-alerts::messages.templates.form.title'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('body')
                        ->label(trans('filament-accounts::messages.accounts.notifications.body'))
                        ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                        ->label(trans('filament-alerts::messages.templates.form.body'))
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('url')
                        ->label(trans('filament-accounts::messages.accounts.notifications.url'))
                        ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                        ->label(trans('filament-alerts::messages.templates.form.url'))
                        ->url()
                        ->maxLength(255),
                    IconPicker::make('icon')
                        ->label(trans('filament-accounts::messages.accounts.notifications.icon'))
                        ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                        ->label(trans('filament-alerts::messages.templates.form.icon'))
                        ->default('heroicon-o-check-circle'),
                    Forms\Components\Select::make('type')
                        ->label(trans('filament-accounts::messages.accounts.notifications.type'))
                        ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                        ->label(trans('filament-alerts::messages.templates.form.type'))
                        ->options(collect(config('filament-alerts.types'))->pluck('name', 'id')->toArray())
                        ->default('success'),
                    Forms\Components\Select::make('providers')
                        ->label(trans('filament-accounts::messages.accounts.notifications.providers'))
                        ->hidden(fn (Forms\Get $get) => $get('use_notification_template'))
                        ->label(trans('filament-alerts::messages.templates.form.providers'))
                        ->multiple()
                        ->options(collect(config('filament-alerts.providers'))->pluck('name', 'id')->toArray()),
                ];
            })
            ->action(function (array $data, $record){
                if($data['use_notification_template']){
                    $template = NotificationsTemplate::find($data['template_id']);
                    if($template){
                        SendNotification::make($template->providers)
                            ->title($template->title)
                            ->template($template->key)
                            ->database(in_array('database', $template->providers))
                            ->privacy('private')
                            ->model(config('filament-accounts.model'))
                            ->id($record->id)
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
                            ->id($record->id)
                            ->fire();
                    }

                    Notification::make()
                        ->title('Notification Sent')
                        ->body('Notification sent successfully')
                        ->success()
                        ->send();
                }
            });
    }
}
