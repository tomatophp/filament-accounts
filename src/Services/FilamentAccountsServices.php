<?php

namespace TomatoPHP\FilamentAccounts\Services;

use Filament\Actions\Action;
use TomatoPHP\FilamentAccounts\Concerns\Impersonates;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\ListAccounts;

class FilamentAccountsServices
{
    use Impersonates;

    private array $relations = [];

    private array $actions = [];

    public function registerAction(array | Action $action, string $page = ListAccounts::class): void
    {
        if (is_array($action)) {
            foreach ($action as $item) {
                if ($item instanceof Action) {
                    $this->actions[$page][] = $item;
                }
            }
        } else {
            $this->actions[$page][] = $action;
        }

    }

    public function getActions(string $page = ListAccounts::class): array
    {
        return $this->actions[$page] ?? [];
    }

    public function register(array | string $relation): void
    {
        if (is_array($relation)) {
            foreach ($relation as $item) {
                $this->relations[] = $item;
            }
        } else {
            $this->relations[] = $relation;
        }
    }

    public function getRelations(): array
    {
        return $this->relations;
    }
}
