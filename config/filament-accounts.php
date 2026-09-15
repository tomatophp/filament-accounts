<?php

use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\AccountForm;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\AccountInfoList;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountActions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountBulkActions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountFilters;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountHeaderActions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountTable;
use TomatoPHP\FilamentAccounts\Models\Account;

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
    'model' => Account::class,

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
            'class' => AccountTable::class,
            'filters' => AccountFilters::class,
            'actions' => AccountActions::class,
            'bulkActions' => AccountBulkActions::class,
            'headerActions' => AccountHeaderActions::class,
        ],
        'form' => [
            'class' => AccountForm::class,
        ],
        'infolist' => [
            'class' => AccountInfoList::class,
        ],
    ],
];
