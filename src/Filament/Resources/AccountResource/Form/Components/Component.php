<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms\Components\Field;

abstract class Component
{
    abstract public static function make(): Field;
}
