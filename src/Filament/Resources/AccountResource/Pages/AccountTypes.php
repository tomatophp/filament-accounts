<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentTypes\Pages\BaseTypePage;
use TomatoPHP\FilamentTypes\Services\Contracts\Type;

class AccountTypes extends BaseTypePage
{
    /**
     * The default account types, created the first time the page is opened.
     */
    public function getTypes(): array
    {
        return [
            Type::make('customer')
                ->name([
                    'ar' => 'عميل',
                    'en' => 'Customer',
                ])
                ->icon('heroicon-c-user-group')
                ->color('#d91919'),
            Type::make('account')
                ->name([
                    'ar' => 'حساب',
                    'en' => 'Account',
                ])
                ->icon('heroicon-c-user-circle')
                ->color('#0a56d9'),
        ];
    }

    /**
     * @param  array<mixed>  $parameters
     */
    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = false, ?string $configuration = null): string
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
