<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;
use TomatoPHP\FilamentTypes\Services\Contracts\Type;

class AccountTypes extends BaseTypePage
{
    public function getTitle(): string
    {
        return trans('filament-accounts::messages.settings.types.title');
    }


    public function getType(): string
    {
        return "type";
    }

    public function getFor(): string
    {
        return "accounts";
    }

    public function getTypes(): array
    {
        return  [
            Type::make("customer")
                ->name([
                    "ar" => "عميل",
                    "en" => "Customer"
                ])
                ->icon("heroicon-c-user-group")
                ->color("#d91919"),
            Type::make("account")
                ->name([
                    "ar" => "حساب",
                    "en" => "Account"
                ])
                ->icon("heroicon-c-user-circle")
                ->color("#0a56d9"),
        ];
    }

}
