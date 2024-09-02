<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;
use TomatoPHP\FilamentTypes\Services\Contracts\Type;

class RequestsTypes extends BaseTypePage
{
    public function getTitle(): string
    {
        return trans('filament-accounts::messages.account-requests.types');
    }


    public function getType(): string
    {
        return "types";
    }

    public function getFor(): string
    {
        return "account-requests";
    }

    public function getTypes(): array
    {
        return  [
            Type::make("account_approve")
                ->name([
                    "ar" => "الموافقة علي الحساب",
                    "en" => "Account Approve"
                ])
                ->icon("heroicon-c-check-circle")
                ->color("#38fc34"),
        ];
    }
}
