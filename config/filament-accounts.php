<?php

return [
    /*
    * Features of Filament Accounts
    *
    * accounts: Enable/Disable Accounts Feature
    */
    'features' => [
        'loginBy' => false,
        'avatar' => false,
        'types' => false,
        'teams' => false,
        'impersonate' => [
            'active' => false,
            'redirect' => '/app',
        ],
    ],

    /*
     * Accounts Configurations
     *
     * login_by: Login By Phone or Email
     */
    'login_by' => 'email',

    /*
     * Accounts Configurations
     *
     * model: User Model Class
     */
    'model' => \TomatoPHP\FilamentAccounts\Models\Account::class,

    /*
     * Use Simple Resource
     *
     * simple: Enable/Disable Simple Resource
     */
    'simple' => true,

    /*
     * Custom Resource
     *
     * to custom resource classes
     */
    'resource' => [
        'table' => [
            'class' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountTable::class,
            'filters' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountFilters::class,
            'actions' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountActions::class,
            'bulkActions' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountBulkActions::class,
            'headerActions' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountHeaderActions::class,
        ],
        'form' => [
            'class' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\AccountForm::class,
        ],
        'infolist' => [
            'class' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\AccountInfoList::class,
        ],
        'pages' => [
            'list' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\ManagePageActions::class,
            'create' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\CreatePageActions::class,
            'edit' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\EditPageActions::class,
            'view' => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\ViewPageActions::class,
        ],
    ],
];
