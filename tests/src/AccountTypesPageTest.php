<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\AccountTypes;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentAccounts\Tests\Models\User;
use TomatoPHP\FilamentTypes\Models\Type;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('renders the account types page', function () {
    get(AccountTypes::getUrl())->assertSuccessful();
});

it('builds the account types url with the Filament page signature', function () {
    expect(AccountTypes::getUrl(isAbsolute: false))->toContain('account-types');
});

it('seeds the default account types when the page is opened', function () {
    get(AccountTypes::getUrl())->assertSuccessful();

    assertDatabaseHas(Type::class, ['for' => 'accounts', 'type' => 'type', 'key' => 'customer']);
    assertDatabaseHas(Type::class, ['for' => 'accounts', 'type' => 'type', 'key' => 'account']);
});

it('registers the account types page when types are enabled', function () {
    $panel = Filament::getCurrentOrDefaultPanel();

    FilamentAccountsPlugin::make()->useTypes()->register($panel);

    expect($panel->getPages())->toContain(AccountTypes::class);
});
