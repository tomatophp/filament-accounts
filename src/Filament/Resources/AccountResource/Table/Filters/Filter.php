<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Filters;

abstract class Filter
{
    abstract public static function make(): \Filament\Tables\Filters\BaseFilter;
}
