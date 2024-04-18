<?php

namespace TomatoPHP\FilamentAccounts\Services\Contracts;

class AccountRelation
{
    public ?string $name;
    public array $label=[];
    public ?string $table;
    public ?string $path;
    public ?string $view;
    public bool $show = false;
    public bool $edit = false;
    public bool $delete = false;

    public static function make(string $name)
    {
        return (new self)->name($name);
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function table(string $table): static
    {
        $this->table = $table;
        return $this;
    }

    public function path(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    public function view(string $view): static
    {
        $this->view = $view;
        return $this;
    }

    public function show(): static
    {
        $this->show = true;
        return $this;
    }

    public function edit(): static
    {
        $this->edit = true;
        return $this;
    }

    public function delete(): static
    {
        $this->delete = true;
        return $this;
    }

    public function label(array $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "label" => $this->label,
            "table" => $this->table,
            "view" => $this->view,
            "show" => $this->show,
            "edit" => $this->edit,
            "delete" => $this->delete,
            "path" => $this->path ?? $this->name
        ];
    }


}
