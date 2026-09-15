<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table;

use Filament\Tables\Filters\BaseFilter;

class AccountFilters
{
    /**
     * @var array
     */
    protected static $filters = [];

    public static function make(): array
    {
        return self::getFilters();
    }

    private static function getDefaultFilters(): array
    {
        return [
            Filters\Trashed::make(),
        ];
    }

    private static function getFilters(): array
    {
        return array_merge(self::getDefaultFilters(), self::$filters);
    }

    public static function register(BaseFilter | array $action): void
    {
        if (is_array($action)) {
            foreach ($action as $item) {
                if ($item instanceof BaseFilter) {
                    self::$filters[] = $item;
                }
            }
        } else {
            self::$filters[] = $action;
        }
    }
}
