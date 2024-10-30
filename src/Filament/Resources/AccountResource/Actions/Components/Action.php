<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Actions\Components;

abstract class Action
{
    abstract public static function make(): \Filament\Actions\Action;
}
