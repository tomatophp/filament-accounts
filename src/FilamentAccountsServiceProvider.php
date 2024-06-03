<?php

namespace TomatoPHP\FilamentAccounts;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use TomatoPHP\FilamentAccounts\Events\SendOTP;
use TomatoPHP\FilamentAccounts\Livewire\SanctumTokens;
use TomatoPHP\FilamentAlerts\Services\SendNotification;
use TomatoPHP\FilamentPlugins\Facades\FilamentPlugins;
use TomatoPHP\FilamentTypes\Facades\FilamentTypes;


class FilamentAccountsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\FilamentAccounts\Console\FilamentAccountsInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-accounts.php', 'filament-accounts');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-accounts.php' => config_path('filament-accounts.php'),
        ], 'filament-accounts-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-accounts-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-accounts');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-accounts'),
        ], 'filament-accounts-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-accounts');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-accounts'),
        ], 'filament-accounts-lang');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->publishes([
            __DIR__ . '/../publish/Account.php' => app_path('Models/Account.php'),
        ], 'filament-accounts-model');

        $this->publishes([
            __DIR__ . '/../publish/migrations/create_teams_table.php' => database_path('migrations/'.  date('Y_m_d_His', ((int)time())+1) . '_create_teams_table.php'),
            __DIR__ . '/../publish/migrations/create_team_invitations_table.php' => database_path('migrations/'.  date('Y_m_d_His', ((int)time())+2) . '_create_team_invitations_table.php'),
            __DIR__ . '/../publish/migrations/create_team_user_table.php' => database_path('migrations/'.  date('Y_m_d_His', ((int)time())+3) . '_create_team_user_table.php'),
        ], 'filament-accounts-teams-migrations');

        $this->publishes([
            __DIR__ . '/../publish/Team.php' => app_path('Models/Team.php'),
            __DIR__ . '/../publish/TeamInvitation.php' => app_path('Models/TeamInvitation.php'),
            __DIR__ . '/../publish/Membership.php' => app_path('Models/Membership.php'),
        ], 'filament-accounts-teams');


        if (config('filament-accounts.features.send_otp')) {
            Event::listen([
                SendOTP::class
            ], function ($data) {
                $user = $data->model::find($data->modelId);

                SendNotification::make(['email'])
                    ->title('OTP')
                    ->message('Your OTP is ' . $user->otp_code)
                    ->type('info')
                    ->database(false)
                    ->model(config('filament-accounts.model'))
                    ->id($user->id)
                    ->privacy('private')
                    ->icon('bx bx-user')
                    ->url(url('/'))
                    ->fire();
            });
        }

        $this->app->bind('filament-accounts', function () {
            return new \TomatoPHP\FilamentAccounts\Services\FilamentAccountsServices();
        });

        $this->app->bind('filament-accounts-auth', function () {
            return new \TomatoPHP\FilamentAccounts\Services\BuildAuth();
        });

        Livewire::component('sanctum-tokens', SanctumTokens::class);

    }

    public function boot(): void
    {

        FilamentTypes::register([
            'types',
            'groups'
        ], 'accounts');

        FilamentTypes::register([
            'status',
            'type',
        ], 'contacts');

    }
}
