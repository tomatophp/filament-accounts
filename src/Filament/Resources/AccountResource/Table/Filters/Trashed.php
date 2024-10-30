<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Filters;

use Filament\Tables\Filters\TrashedFilter;

class Trashed extends Filter
{
    public static function make(): \Filament\Tables\Filters\BaseFilter
    {
        return TrashedFilter::make();
    }
}
