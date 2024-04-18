<?php

namespace TomatoPHP\FilamentAccounts\Services\Contracts;

class WebResponse
{
    public ?string $message = null;
    public ?string $type = "success";
    public ?bool $success = false;

    public static function make(?string $message): static
    {
        return (new static())->message($message);
    }

    public function message(?string $message): static
    {
        $this->message = $message;
        return $this;
    }

    public function type(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function success(): static
    {
        $this->success = true;
        return $this;
    }
}
