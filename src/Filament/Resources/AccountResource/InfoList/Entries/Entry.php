<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\Entries;

abstract class Entry
{
    abstract public static function make(): \Filament\Infolists\Components\Entry;
}
