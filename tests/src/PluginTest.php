<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;

it('registers plugin', function () {
    $panel = Filament::getCurrentOrDefaultPanel();

    $panel->plugins([
        FilamentAccountsPlugin::make(),
    ]);

    expect($panel->getPlugin('filament-accounts'))
        ->not()
        ->toThrow(Exception::class);
});
