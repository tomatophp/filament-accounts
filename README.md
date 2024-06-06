![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/3x1io-tomato-accounts.jpg)

# Filament Accounts Builder

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-accounts/version.svg)](https://packagist.org/packages/tomatophp/filament-accounts)
[![PHP Version Require](http://poser.pugx.org/tomatophp/filament-accounts/require/php)](https://packagist.org/packages/tomatophp/filament-accounts)
[![License](https://poser.pugx.org/tomatophp/filament-accounts/license.svg)](https://packagist.org/packages/tomatophp/filament-accounts)
[![Downloads](https://poser.pugx.org/tomatophp/filament-accounts/d/total.svg)](https://packagist.org/packages/tomatophp/filament-accounts)

full accounts manager with API/Notifications/Contacts to manage your contacts and accounts

## Screenshots

![Accounts List](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/accounts-list.png)
![Change Password](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/change-password.png)
![Send Notifications](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/send-notifications.png)
![Edit Account](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/edit-account.png)
![Accounts Locations](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/account-locations.png)
![Accounts Requests](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/account-requests.png)
![Edit Request](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/edit-request.png)
![Contacts](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/contacts.png)



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
        "accounts" => true,
        "locations" => true,
        "contacts" => true,
        "requests" => true,
        "notifications" => true,
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
        "actions" => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\AccountsActions::class,
        "filters" => \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Filters\AccountsFilters::class,
        "pages" =>  \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\AccountPagesList::class,
    ],

    "teams" => [
        "allowed" => false,
        "model" => \TomatoPHP\FilamentAccounts\Models\Team::class,
        "invitation" => \TomatoPHP\FilamentAccounts\Models\TeamInvitation::class,
        "membership" => \TomatoPHP\FilamentAccounts\Models\Membership::class,
        "resource" => \TomatoPHP\FilamentAccounts\Filament\Resources\TeamResource::class,
    ]

];

```

## Usage

this plugin makes it easy to make a starting point for your app if this app has customers to manage

but here is the problem, every app has a different way of managing customers, so we built a Facade service to control the way you want to manage your customers

### Use Accounts as SaaS Panel

![Register](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/register.png)
![OTP](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/otp.png)
![Panel Home](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/panel-home.png)
![Panel Menu](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/panel-menu.png)
![Edit Profile](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/edit-profile.png)
![Manage Sessions](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/manage-sessions.png)
![Team Settings](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/team-settings.png)
![Invite Team](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/invite-team.png)
![API Tokens](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/arts/api-tokens.png)

install jetstream without install it.

```bash
composer require laravel/jetstream
```

on your new panel just use this plugin

```php
->plugin(
    FilamentAccountsSaaSPlugin::make()
        ->databaseNotifications()
        ->checkAccountStatusInLogin()
        ->APITokenManager()
        ->editTeam()
        ->deleteTeam()
        ->teamInvitation()
        ->showTeamMembers()
        ->editProfile()
        ->editPassword()
        ->browserSesstionManager()
        ->deleteAccount()
        ->editProfileMenu()
        ->registration()
        ->useOTPActivation(),
)
```

you can change settings by remove just methods from plugin.

### Use Account Column

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

## Use Filament Impersonate

you can use the impersonate to impersonate the user by install it first

```bash
composer require stechstudio/filament-impersonate
```

now on your `filament-users.php` config allow shield

```php
"features" => [
    ...
    "impersonate" => [
        'active'=> true,
        'redirect' => '/app',
    ],
],
```

now clear your config

```bash
php artisan config:cache
```

for more information check the [Filament Impersonate](https://github.com/stechstudio/filament-impersonate)

### How to use builder

just install the package and you will get everything working, it supports some features ready to use:

* Accounts
* Locations
* Contact Us
* Send Notifications
* Auth APIs
* Send OTP Events

you can activate or deactivate any feature you want from the package config file.

## Custom create / edit validation

you can custom the validation rules for creating / editing accounts by just passing the rules you want to the facade service method

```php

use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;

public function boot()
{
    FilamentAccounts::validation(
        create: [
            'email' => 'unique:accounts,email',
            'type_id' => 'required|integer|exists:types,id',
        ],
        edit: [
            'email' => 'sometimes|unique:accounts,email',
            'type_id' => 'sometimes|integer|exists:types,id',
        ],
        api_create: [
            'email' => 'unique:accounts,email',
            'type_id' => 'required|integer|exists:types,id',
        ],
        api_edit: [
            'email' => 'sometimes|unique:accounts,email',
            'type_id' => 'sometimes|integer|exists:types,id',
        ]
    );

}
```

by using this method you can custom the validation rules for creating / editing accounts on the web and APIs

## Attach New Field To Accounts

you can attach a new field to the accounts table by just passing the field name and the field type to the facade service method

```php

use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;

public function boot()
{
    FilamentAccounts::attach(
        key: 'birthday',
        label: __('Birthday'),
        type: 'date',
        show_on_create: false,
        show_on_edit: false
    );
}
```

### Attach Relation To Accounts

you can attach a new relation to the accounts relations manager by just passing the relation class to the facade service method

```php
use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;

public function boot()
{
    FilamentAccounts::registerAccountRelation([
        AccountOrdersRelationManager::make()
    ]);
}
```

### Attach Table Button

you can attach a new button to the accounts table by just passing the button class to the facade service method

```php
use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;

public function boot()
{
    FilamentAccounts::registerAccountActions([
        \Filament\Tables\Actions\Action::make('orders')
    ]);
}
```

## Auth Events

we have added a lot of events to the package, so you can listen to them and do what you want.

### OTP Event

```php
use TomatoPHP\FilamentAccounts\Events\SendOTP;
use TomatoPHP\FilamentAlerts\Services\SendNotification;

public function register()
{
    Event::listen([
        SendOTP::class
    ], function ($data) {
        $user = $data->model::find($data->modelId);

        SendNotification::make(['email'])
            ->title('OTP')
            ->message('Your OTP is ' . $user->otp_code)
            ->type('info')
            ->database(false)
            ->model(Account::class)
            ->id($user->id)
            ->privacy('private')
            ->icon('bx bx-user')
            ->url(url('/'))
            ->fire();
    });
}
```

### Account Success Login Event

When the user logs in successfully, we fire this event.

```php
use TomatoPHP\FilamentAccounts\Events\AccountLogged;

public function register()
{
    Event::listen([
        AccountLogged::class
    ], function ($data) {
        $user = $data->model::find($data->modelId);
        if($user->meta('is_admin_approve') !== 'yes'){
            return response()->json([
                "status" => false,
                "message" => __('your Account is activated. but you cannot login till admin approve.'),
            ], 400)->send();
        }
    });
}
```

### Account Registered Event

When the user registers successfully, we fire this event.

```php
use TomatoPHP\FilamentAccounts\Events\AccountLogged;

public function register()
{
    Event::listen([
        AccountRegistered::class
    ], function ($data) {
        $user = $data->model::find($data->modelId);
        $user->last_login = Carbon::now();
        $user->save();
    });
}
```

## Use Auth Builder

you can build multi-auth using the same accounts table in a very easy way, so we created a Facade class to help you do that.

### How to use

you just need to create 2 controllers `AuthController`, `ProfileController`

```php

use TomatoPHP\FilamentAccounts\Services\Traits\Auth\Login;
use TomatoPHP\FilamentAccounts\Services\Traits\Auth\Register;
use TomatoPHP\FilamentAccounts\Services\Traits\Auth\Otp;
use TomatoPHP\FilamentAccounts\Services\Traits\Auth\ResetPassword;

class AuthController extends Controller
{
    use Login;
    use Register;
    use Otp;
    use ResetPassword;
    
    public string $guard = 'web';
    public bool $otp = true;
    public string $model = Account::class;
    public string $loginBy = 'email';
    public string $loginType = 'email';
    public ?string $resource = null;

    public function __construct()
    {
        $this->guard = config('filament-accounts.guard');
        $this->otp = config('filament-accounts.required_otp');
        $this->model = config('filament-accounts.model');
        $this->loginBy = config('filament-accounts.login_by');
        $this->loginType = config('filament-accounts.login_by');
        $this->resource = config('filament-accounts.resource', null);
    }
```

and on your profile controller, you just need to use `Profile` traits

```php
use TomatoPHP\FilamentAccounts\Services\Traits\Auth\Profile\User;
use TomatoPHP\FilamentAccounts\Services\Traits\Auth\Profile\Update;
use TomatoPHP\FilamentAccounts\Services\Traits\Auth\Profile\Delete;
use TomatoPHP\FilamentAccounts\Services\Traits\Auth\Profile\Logout;

class ProfileController extends Controller
{
    use User;
    use Update;
    use Delete;
    use Logout;

    public string $guard = 'web';
    public bool $otp = true;
    public string $model = Account::class;
    public string $loginBy = 'email';
    public string $loginType = 'email';
    public ?string $resource = null;

    public function __construct()
    {
        $this->guard = config('filament-accounts.guard');
        $this->otp = config('filament-accounts.required_otp');
        $this->model = config('filament-accounts.model');
        $this->loginBy = config('filament-accounts.login_by');
        $this->loginType = config('filament-accounts.login_by');
        $this->resource = config('filament-accounts.resource', null);
    }
}
```

## APIs

we have added a lot of APIs to the package, so you can use them to manage your accounts. please check this file [API Collection](https://raw.githubusercontent.com/tomatophp/filament-accounts/master/api_collection.json)

## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/Xqmt35Uh)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

