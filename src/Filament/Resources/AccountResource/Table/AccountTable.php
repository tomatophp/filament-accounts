<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;

class AccountTable
{
    protected static array $columns = [];

    public static function make(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->bulkActions(config('filament-accounts.resource.table.bulkActions') ? config('filament-accounts.resource.table.bulkActions')::make() : AccountBulkActions::make())
            ->actions(config('filament-accounts.resource.table.actions') ? config('filament-accounts.resource.table.actions')::make() : AccountActions::make())
            ->filters(config('filament-accounts.resource.table.filters') ? config('filament-accounts.resource.table.filters')::make() : AccountFilters::make())
            ->headerActions(config('filament-accounts.resource.table.headerActions') ? config('filament-accounts.resource.table.headerActions')::make() : AccountHeaderActions::make())
            ->defaultSort('id', 'desc')
            ->columns(self::getColumns());
    }

    public static function getDefaultColumns(): array
    {
        return [
            Columns\Id::make(),
            Columns\Name::make(),
            Columns\Email::make(),
            Columns\Phone::make(),
            Columns\CreatedAt::make(),
            Columns\UpdatedAt::make(),
        ];
    }

    private static function getColumns(): array
    {
        return array_merge(self::getDefaultColumns(), self::$columns);
    }

    public static function register(Column | array $column): void
    {
        if (is_array($column)) {
            foreach ($column as $item) {
                if ($item instanceof Column) {
                    self::$columns[] = $item;
                }
            }
        } else {
            self::$columns[] = $column;
        }
    }
}
