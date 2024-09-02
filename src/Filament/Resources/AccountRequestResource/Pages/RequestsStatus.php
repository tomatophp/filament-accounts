<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;
use TomatoPHP\FilamentTypes\Services\Contracts\Type;

class RequestsStatus extends BaseTypePage
{
    public function getTitle(): string
    {
        return trans('filament-accounts::messages.account-requests.status');
    }


    public function getType(): string
    {
        return "status";
    }

    public function getFor(): string
    {
        return "account-requests";
    }

    public function getTypes(): array
    {
        return  [
            Type::make("pending")
                ->name([
                    "ar" => "تحت المراجعة",
                    "en" => "Pending"
                ])
                ->icon("heroicon-c-pause-circle")
                ->color("#ffcf00"),
            Type::make("active")
                ->name([
                    "ar" => "جاري المتابعة",
                    "en" => "Active"
                ])
                ->icon("heroicon-c-play-circle")
                ->color("#1897ff"),
            Type::make("closed")
                ->name([
                    "ar" => "تم اغلاقها",
                    "en" => "Closed"
                ])
                ->icon("heroicon-c-check-circle")
                ->color("#38fc34"),
        ];
    }
}
