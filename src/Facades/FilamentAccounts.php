<?php

namespace TomatoPHP\FilamentAccounts\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TomatoPHP\FilamentAccounts\Services\FilamentAccountsServices
 *
 * @method static void register(array|string $relation)
 *                                                      * @method static array getRelations()
 */
class FilamentAccounts extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'filament-accounts';
    }
}
