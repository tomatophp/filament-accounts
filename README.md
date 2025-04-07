![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/3x1io-tomato-accounts.jpg)

# Filament Accounts Builder

[![Dependabot Updates](https://github.com/tomatophp/filament-accounts/actions/workflows/dependabot/dependabot-updates/badge.svg)](https://github.com/tomatophp/filament-accounts/actions/workflows/dependabot/dependabot-updates)
[![PHP Code Styling](https://github.com/tomatophp/filament-accounts/actions/workflows/fix-php-code-styling.yml/badge.svg)](https://github.com/tomatophp/filament-accounts/actions/workflows/fix-php-code-styling.yml)
[![Tests](https://github.com/tomatophp/filament-accounts/actions/workflows/tests.yml/badge.svg)](https://github.com/tomatophp/filament-accounts/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-accounts/version.svg)](https://packagist.org/packages/tomatophp/filament-accounts)
[![License](https://poser.pugx.org/tomatophp/filament-accounts/license.svg)](https://packagist.org/packages/tomatophp/filament-accounts)
[![Downloads](https://poser.pugx.org/tomatophp/filament-accounts/d/total.svg)](https://packagist.org/packages/tomatophp/filament-accounts)

Manage your multi accounts inside your app using 1 table with multi auth and a lot of integrations

> [!CAUTION]
> Don't update to v2.3 if you are using v2.2 or less because you will lose some features but you can update and use this features from integrated packages.

## Screenshots

![Accounts List](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/accounts-list.png)
![Change Password](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/change-password.png)
![Send Notifications](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/send-notifications.png)
![Edit Account](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/edit-account.png)

## Features

- [x] Accounts Manager
- [x] Account Types `not tested`
- [x] Account Login By `not tested`
- [x] Account Active/Block `not tested`
- [x] Account Avatar `not tested`
- [x] Account Impersonate Integration `not tested`
- [x] Account Table Column `not tested`
- [x] Export `not tested`
- [x] Import `not tested`
- [ ] Account Filament Alerts Integration
- [ ] Account Teams
- [ ] Google Contacts Integrations

## Use Case

you can use this package if you like to build a CRM or a multi-accounts app

## Installation

```bash
composer require tomatophp/filament-accounts
```

after install your package please run this command

```bash
php artisan filament-accounts:install
```

if you are not using this package as a plugin please register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make())
```

## Publish Account Model

you can publish your account model to add other relations or implement some interfaces by using this command

```bash
php artisan vendor:publish --tag="filament-accounts-model"
```

now go to your `filament-accounts.php` config file and change the model value to the new one.

if you don't find it you can publish it

```
php artisan vendor:publish --tag="filament-accounts-config"
```

## Add Accounts Guard

now you need to add a new guard to your auth.php config like this

```php
<?php

return [
 /*
    * Features of Tomato CRM
    *
    * accounts: Enable/Disable Accounts Feature
    */
    "features" => [
        "notifications" => false,
        "loginBy" => false,
        "avatar" => false,
        "types" => false,
        "teams" => false,
        "impersonate" => [
            'active'=> false,
            'redirect' => '/app',
        ],
    ],

    /*
     * Accounts Configurations
     *
     * login_by: Login By Phone or Email
     */
    "login_by" => "email",

    /*
     * Accounts Configurations
     *
     * model: User Model Class
     */
    "model" => \TomatoPHP\FilamentAccounts\Models\Account::class,
    
    
    
];

```

## Usage

this plugin makes it easy to make a starting point for your app if this app has customers to manage

but here is the problem, every app has a different way of managing customers, so we built a Facade service to control the way you want to manage your customers

### Use Avatar

add this method to your plugin in `AdminPanelProvider.php`

```php
->plugin(
    \TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make()
        ->useAvatar()
)
```

## Hide Resource

just allow `->()` on the plugin

```php
->plugin(\TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make()
    ->useTypes()
)
```

## Use Filament Types

just allow `->useResource()` on the plugin

```php
->plugin(\TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make()
    ->useResource()
)
```

## Show Address Field

you can show or hide address field on the create or edit form by using this code

```php

->plugin(\TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make()
    ->showAddressField()
)
```

## Show Type Field

you can show or hide type field on the create or edit form by using this code

```php

->plugin(\TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make()
    ->showTypeField()
)
```

## Attach Relation To Accounts

you can attach a new relation to the accounts relations manager by just passing the relation class to the facade service method

```php
use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;

public function boot()
{
    FilamentAccounts::register([
        AccountOrdersRelationManager::make()
    ]);
}
```

## Use Export & Import Actions

now on your main panel provider add `->useExport()` , `->useImport()` to the plugin

```php
->plugin(\TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make()
    ...
    ->useExport()
    ->useImport()
)
```

## Use Account Column

![Account Column](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/account-column.png)

you can use the account column in any table by using this code

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            AccountColumn::make('account.id'),
        ]);
}
```

just pass the account id to the column


### Use Filament Impersonate

you can use the impersonate to impersonate the user by install it first

```bash
composer require stechstudio/filament-impersonate
```

now on your main panel provider add `->useImpersonate()` , `->impersonateRedirect('/app')` to the plugin

```php
->plugin(\TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make()
    ...
    ->useImpersonate()
    ->impersonateRedirect('/app')
)
```

now clear your config

```bash
php artisan config:cache
```

for more information check the [Filament Impersonate](https://github.com/stechstudio/filament-impersonate)

## Testing

if you like to run `PEST` testing just use this command

```bash
composer test
```

## Code Style

if you like to fix the code style just use this command

```bash
composer format
```

## PHPStan

if you like to check the code by `PHPStan` just use this command

```bash
composer analyse
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
