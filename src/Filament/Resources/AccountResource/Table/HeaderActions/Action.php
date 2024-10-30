<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\HeaderActions;

abstract class Action
{
    abstract public static function make(): \Filament\Tables\Actions\Action;
}
