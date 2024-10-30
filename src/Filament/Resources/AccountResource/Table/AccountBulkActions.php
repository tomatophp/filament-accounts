<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table;

use Filament\Tables;
use Filament\Tables\Actions\BulkAction;

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
            Tables\Actions\ForceDeleteBulkAction::make(),
            Tables\Actions\RestoreBulkAction::make(),
        ];
    }

    private static function getActions(): array
    {
        return array_merge(self::getDefaultActions(), self::$actions);
    }

    public static function register(BulkAction | array $action): void
    {
        if (is_array($action)) {
            foreach ($action as $item) {
                if ($item instanceof BulkAction) {
                    self::$actions[] = $item;
                }
            }
        } else {
            self::$actions[] = $action;
        }
    }
}
