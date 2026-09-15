<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Filters;

use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\TrashedFilter;

class Trashed extends Filter
{
    public static function make(): BaseFilter
    {
        return TrashedFilter::make();
    }
}
