<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList;

use Filament\Infolists\Components\Entry;
use Filament\Infolists\Infolist;

class AccountInfoList
{
    protected static array $schema = [];

    public static function make(Infolist $infolist): Infolist
    {
        return $infolist->schema(self::getSchema())->columns(2);
    }

    public static function getDefaultComponents(): array
    {
        return [
            Entries\Name::make(),
            Entries\Email::make(),
            Entries\Phone::make(),
        ];
    }

    private static function getSchema(): array
    {
        return array_merge(self::getDefaultComponents(), self::$schema);
    }

    public static function register(Entry | array $component): void
    {
        if (is_array($component)) {
            foreach ($component as $item) {
                if ($item instanceof Entry) {
                    self::$schema[] = $item;
                }
            }

        } else {
            self::$schema[] = $component;
        }
    }
}
