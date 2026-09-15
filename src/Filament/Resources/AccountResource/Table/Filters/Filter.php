<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Filters;

use Filament\Tables\Filters\BaseFilter;

abstract class Filter
{
    abstract public static function make(): BaseFilter;
}
