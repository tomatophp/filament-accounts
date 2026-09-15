<?php

use TomatoPHP\FilamentTypes\Models\Type;

use function Pest\Laravel\assertDatabaseHas;

it('runs the install command', function () {
    $this->artisan('filament-accounts:install')
        ->expectsOutput('Filament Accounts installed successfully.')
        ->assertSuccessful();
});

it('seeds the account types when the types feature is enabled', function () {
    config()->set('filament-accounts.features.types', true);

    $this->artisan('filament-accounts:install')->assertSuccessful();

    assertDatabaseHas(Type::class, [
        'key' => 'customer',
        'for' => 'accounts',
        'type' => 'type',
    ]);
});
