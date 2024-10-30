<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\Columns;

abstract class Column
{
    abstract public static function make(): \Filament\Tables\Columns\Column;
}
