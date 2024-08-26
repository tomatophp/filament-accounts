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
    ]
];
