<?php

namespace TomatoPHP\FilamentAccounts\Facades;

use Illuminate\Support\Facades\Facade;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\ListAccounts;

/**
 * @see \TomatoPHP\FilamentAccounts\Services\FilamentAccountsServices
 *
 * @method static void register(array|string $relation)
 * @method static array getRelations()
 * @method static array registerAction(array|string $action, string $page = ListAccounts::class)
 * @method static array getActions(string $page = ListAccounts::class)
 */
class FilamentAccounts extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'filament-accounts';
    }
}
