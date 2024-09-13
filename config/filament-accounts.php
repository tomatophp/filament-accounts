<?php

return [
    /*
    * Features of Tomato CRM
    *
    * accounts: Enable/Disable Accounts Feature
    */
    "features" => [
        "accounts" => true,
        "meta" => true,
        "locations" => true,
        "contacts" => true,
        "requests" => true,
        "notifications" => true,
        "loginBy" => true,
        "avatar" => true,
        "types" => false,
        "teams" => false,
        "apis" => true,
        "send_otp" => true,
        "impersonate" => [
            'active'=> false,
            'redirect' => '/app',
        ],
    ],

    /*
     * Accounts Configurations
     *
     * resource: User Resource Class
     */
    "resource" => null,

    /*
     * Accounts Configurations
     *
     * login_by: Login By Phone or Email
     */
    "login_by" => "email",

    /*
     * Accounts Configurations
     *
     * required_otp: Enable/Disable OTP Verification
     */
    "required_otp" => true,

    /*
     * Accounts Configurations
     *
     * model: User Model Class
     */
    "model" => \TomatoPHP\FilamentAccounts\Models\Account::class,

    /*
     * Accounts Configurations
     *
     * guard: Auth Guard
     */
    "guard" => "accounts",


    "teams" => [
        "allowed" => false,
        "model" => \TomatoPHP\FilamentAccounts\Models\Team::class,
        "invitation" => \TomatoPHP\FilamentAccounts\Models\TeamInvitation::class,
        "membership" => \TomatoPHP\FilamentAccounts\Models\Membership::class,
        "resource" => \TomatoPHP\FilamentAccounts\Filament\Resources\TeamResource::class,
    ],

    /**
     * Accounts Relations Managers
     *
     * you can set selected relations to show in account resource
     */
    "relations" => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Releations\AccountReleations::class,
    

    /**
     * Accounts Resource Builder
     *
     * you can change the form, table, actions and filters of account resource by using filament-helpers class commands
     *
     * link: https://github.com/tomatophp/filament-helpers
     */
    "accounts" => [
        "form" => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Forms\AccountsForm::class,
        "table" => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Tables\AccountsTable::class,
        "actions" => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\AccountsTableActions::class,
        "filters" => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Filters\AccountsFilters::class,
        "pages" => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\AccountPagesList::class,
    ]
];
