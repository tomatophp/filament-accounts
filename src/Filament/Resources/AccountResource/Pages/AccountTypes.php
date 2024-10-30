<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentTypes\Pages\BaseTypePage;

class AccountTypes extends BaseTypePage
{
    /**
     * @param  array<mixed>  $parameters
     */
    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        if (blank($panel) || Filament::getPanel($panel)->hasTenancy()) {
            $parameters['tenant'] ??= ($tenant ?? Filament::getTenant());
        }

        return route(static::getRouteName($panel), $parameters, $isAbsolute);
    }

    public function getTitle(): string
    {
        return trans('filament-accounts::messages.settings.types.title');
    }

    public function getType(): string
    {
        return 'type';
    }

    public function getFor(): string
    {
        return 'accounts';
    }
}
