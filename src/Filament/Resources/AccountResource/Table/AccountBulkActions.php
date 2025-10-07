<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table;

use Filament\Actions;

class AccountBulkActions
{
    /**
     * @var array
     */
    protected static $actions = [];

    public static function make(): array
    {
        return self::getActions();
    }

    private static function getDefaultActions(): array
    {
        return [
            BulkActions\DeleteAction::make(),
            Actions\ForceDeleteBulkAction::make(),
            Actions\RestoreBulkAction::make(),
        ];
    }

    private static function getActions(): array
    {
        return array_merge(self::getDefaultActions(), self::$actions);
    }

    public static function register(Actions\BulkAction | array $action): void
    {
        if (is_array($action)) {
            foreach ($action as $item) {
                if ($item instanceof Actions\BulkAction) {
                    self::$actions[] = $item;
                }
            }
        } else {
            self::$actions[] = $action;
        }
    }
}
