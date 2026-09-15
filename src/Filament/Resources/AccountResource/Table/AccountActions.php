<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table;

use Filament\Actions\Action;

class AccountActions
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
            Actions\ViewAction::make(),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    private static function getActions(): array
    {
        return array_merge(self::getDefaultActions(), self::$actions);
    }

    public static function register(Action | array $action): void
    {
        if (is_array($action)) {
            foreach ($action as $item) {
                if ($item instanceof Action) {
                    self::$actions[] = $item;
                }
            }
        } else {
            self::$actions[] = $action;
        }
    }
}
