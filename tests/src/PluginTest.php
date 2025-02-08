<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;

it('registers plugin', function () {
    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        FilamentAccountsPlugin::make(),
    ]);

    expect($panel->getPlugin('filament-accounts'))
        ->not()
        ->toThrow(Exception::class);
});

// it('can modify avatar', function ($condition) {
//    $plugin = FilamentAccountsPlugin::make()
//        ->useAvatar($condition);
//
//    expect($plugin::hasAvatar())->toBe($condition);
// })->with([
//    false,
//    fn () => true,
// ]);
