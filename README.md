![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/fadymondy-tomato-accounts.jpg)

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

![Accounts List](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/accounts-list-light.png)
![Accounts List Dark](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/accounts-list-dark.png)
![Create Account](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/accounts-create-light.png)
![Create Account Dark](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/accounts-create-dark.png)
![Account Types](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/account-types-light.png)
![Account Types Dark](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/account-types-dark.png)

## Features

- [x] Accounts Manager
- [x] Account Types
- [x] Account Login By
- [x] Account Active/Block
- [x] Account Avatar
- [x] Account Impersonate Integration
- [x] Account Table Column
- [x] Export
- [x] Import
- [ ] Account Filament Alerts Integration
- [ ] Account Teams
- [ ] Google Contacts Integrations

## Use Case

you can use this package if you like to build a CRM or a multi-accounts app

## Compatibility

| Package version | Filament | Laravel    | PHP  |
|-----------------|----------|------------|------|
| 5.x             | 5.x      | 12.x, 13.x | 8.2+ |
| 4.x             | 4.x      | 11.x, 12.x | 8.2+ |

## Installation

```bash
composer require tomatophp/filament-accounts:^5.0
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

now you need to add a new guard to your `config/auth.php` like this (the impersonate action signs in with the `accounts` guard)

```php
'guards' => [
    // ...
    'accounts' => [
        'driver' => 'session',
        'provider' => 'accounts',
    ],
],

'providers' => [
    // ...
    'accounts' => [
        'driver' => 'eloquent',
        'model' => \TomatoPHP\FilamentAccounts\Models\Account::class,
    ],
],
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

just allow `useResource->()` on the plugin

```php
->plugin(\TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make()
    ->useResource(false)
)
```

## Use Filament Types

just allow `->useTypes()` on the plugin, it adds a type field, column and filter to the resource and an "Accounts Types" page to manage them (powered by [tomatophp/filament-types](https://github.com/tomatophp/filament-types))

```php
->plugin(\TomatoPHP\FilamentAccounts\FilamentAccountsPlugin::make()
    ->useTypes()
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

impersonation is powered by [lab404/laravel-impersonate](https://github.com/404labfr/laravel-impersonate) (installed with this package) and signs in with the `accounts` guard from the [Add Accounts Guard](#add-accounts-guard) section.

on your main panel provider add `->useImpersonate()` , `->impersonateRedirect('/app')` to the plugin

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
