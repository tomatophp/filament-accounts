<?php

namespace TomatoPHP\FilamentAccounts\Components;

use Filament\Tables\Columns\TextColumn;

class AccountColumn extends TextColumn
{
    protected string $view = 'filament-accounts::components.account-column';

    protected bool $avatar = true;

    public function avatar(bool $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }
}
