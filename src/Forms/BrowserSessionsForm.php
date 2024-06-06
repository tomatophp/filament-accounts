<?php

namespace TomatoPHP\FilamentAccounts\Forms;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Agent;

class BrowserSessionsForm
{
    public static function get(): array
    {
        return [
            Section::make(trans('filament-accounts::messages.profile.browser.browser_section_title'))
                ->description(trans('filament-accounts::messages.profile.browser.browser_section_description'))
                ->schema([
                    Forms\Components\ViewField::make('browserSessions')
                        ->label(__(trans('filament-accounts::messages.profile.browser.browser_section_title')))
                        ->hiddenLabel()
                        ->view('filament-accounts::forms.components.browser-sessions')
                        ->viewData(['data' => self::getSessions()]),
                    Actions::make([
                        Actions\Action::make('deleteBrowserSessions')
                            ->label(trans('filament-accounts::messages.profile.browser.browser_sessions_log_out'))
                            ->requiresConfirmation()
                            ->modalHeading(trans('filament-accounts::messages.profile.browser.browser_sessions_log_out'))
                            ->modalDescription(trans('filament-accounts::messages.profile.browser.browser_sessions_confirm_pass'))
                            ->modalSubmitActionLabel(trans('filament-accounts::messages.profile.browser.browser_sessions_log_out'))
                            ->form([
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->revealable()
                                    ->label(trans('filament-accounts::messages.profile.browser.password'))
                                    ->required(),
                            ])
                            ->action(function (array $data) {
                                self::logoutOtherBrowserSessions($data['password']);

                                Notification::make()
                                    ->title('Success')
                                    ->success()
                                    ->send();
                            })
                            ->modalWidth('2xl'),
                    ]),

                ]),
        ];
    }

    public static function getSessions(): array
    {
        if (config(key: 'session.driver') !== 'database') {
            return [];
        }

        return collect(
            value: DB::connection(config(key: 'session.connection'))->table(table: config(key: 'session.table', default: 'sessions'))
                ->where(column: 'user_id', operator: Auth::user()->getAuthIdentifier())
                ->latest(column: 'last_activity')
                ->get()
        )->map(callback: function ($session): object {
            $agent = self::createAgent($session);

            return (object) [
                'device' => [
                    'browser' => $agent->browser(),
                    'desktop' => $agent->isDesktop(),
                    'mobile' => $agent->isMobile(),
                    'tablet' => $agent->isTablet(),
                    'platform' => $agent->platform(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        })->toArray();
    }

    protected static function createAgent(mixed $session)
    {
        return tap(
            value: new Agent(),
            callback: fn ($agent) => $agent->setUserAgent(userAgent: $session->user_agent)
        );
    }

    public static function logoutOtherBrowserSessions($password): void
    {

        if (! Hash::check($password, Auth::user()->password)) {
            Notification::make()
                ->danger()
                ->title(trans('filament-accounts::messages.profile.browser.incorrect_password'))
                ->send();

            return;
        }

        Auth::guard()->logoutOtherDevices($password);

        request()->session()->put([
            'password_hash_' . Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
        ]);

        self::deleteOtherSessionRecords();
    }

    protected static function deleteOtherSessionRecords()
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }
}
