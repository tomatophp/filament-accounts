<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\ContactResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;

class ContactStatusTypes extends BaseTypePage
{
    public function getType(): string
    {
        return "status";
    }

    public function getFor(): string
    {
        return "contacts";
    }

    public function getTypes(): array
    {
        return [
            [
                "name" => [
                    "ar" => "تحت المراجعة",
                    "en" => "Pending"
                ],
                "key" => "pending",
                "for" => "contacts",
                "type" => "status",
                "icon" => "heroicon-c-pause-circle",
                "color" => "#ffcf00"
            ],
            [
                "name" => [
                    "ar" => "جاري المتابعة",
                    "en" => "Active"
                ],
                "key" => "active",
                "for" => "contacts",
                "type" => "status",
                "icon" => "heroicon-c-play-circle",
                "color" => "#1897ff"
            ],
            [
                "name" => [
                    "ar" => "تم اغلاقها",
                    "en" => "Closed"
                ],
                "key" => "closed",
                "for" => "contacts",
                "type" => "status",
                "icon" => "heroicon-c-check-circle",
                "color" => "#38fc34"
            ],
            [
                "name" => [
                    "ar" => "الموافقة علي الحساب",
                    "en" => "Account Approve"
                ],
                "key" => "account_approve",
                "for" => "contacts",
                "type" => "type",
                "icon" => "heroicon-c-check-circle",
                "color" => "#38fc34"
            ]
        ];
    }
}
