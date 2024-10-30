<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form;

use Filament\Forms\Components\Field;
use Filament\Forms\Form;

class AccountForm
{
    protected static array $schema = [];

    public static function make(Form $form): Form
    {
        return $form->schema(self::getSchema())->columns(2);
    }

    public static function getDefaultComponents(): array
    {
        return [
            Components\Name::make(),
            Components\Email::make(),
            Components\Phone::make(),
        ];
    }

    private static function getSchema(): array
    {
        return array_merge(self::getDefaultComponents(), self::$schema);
    }

    public static function register(Field | array $component): void
    {
        if (is_array($component)) {
            foreach ($component as $item) {
                if ($item instanceof Field) {
                    self::$schema[] = $item;
                }
            }

        } else {
            self::$schema[] = $component;
        }
    }
}
