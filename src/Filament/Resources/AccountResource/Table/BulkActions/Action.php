<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\BulkActions;

use Filament\Actions\BulkAction;

abstract class Action
{
    abstract public static function make(): BulkAction;
}
