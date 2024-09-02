<?php

namespace TomatoPHP\FilamentAccounts\Services\Contracts;

use Illuminate\Support\Collection;

class AccountRequestForm
{
    public array $schema = [];
    public ?string $type = null;

    public static function make(string $type): static
    {
        return (new static())->type($type);
    }

    public function type(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function schema(array $schema): static
    {
        $this->schema = $schema;
        return $this;
    }

    public function toCollection(): Collection
    {
        return collect($this);
    }
}
