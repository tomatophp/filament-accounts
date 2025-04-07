<?php

namespace TomatoPHP\FilamentAccounts\Tests;

use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages;
use TomatoPHP\FilamentAccounts\Tests\Models\Account;
use TomatoPHP\FilamentAccounts\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertNotEmpty;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can render account resource', function () {
    get(AccountResource::getUrl())->assertSuccessful();
});

it('can list posts', function () {
    Account::query()->delete();
    $accounts = Account::factory()->count(10)->create();

    livewire(Pages\ListAccounts::class)
        ->loadTable()
        ->assertCanSeeTableRecords($accounts)
        ->assertCountTableRecords(10);
});

it('can render account name/email/phone column in table', function () {
    Account::factory()->count(10)->create();

    livewire(Pages\ListAccounts::class)
        ->loadTable()
        ->assertCanRenderTableColumn('id')
        ->assertCanRenderTableColumn('name')
        ->assertCanRenderTableColumn('phone')
        ->assertCanRenderTableColumn('email');
});

it('can render account list page', function () {
    livewire(Pages\ListAccounts::class)->assertSuccessful();
});

it('can render view account action', function () {
    livewire(Pages\ManageAccounts::class, [
        'record' => Account::factory()->create(),
    ])
        ->mountAction('view')
        ->assertSuccessful();
});

it('can render view account page', function () {
    get(AccountResource::getUrl('view', [
        'record' => Account::factory()->create(),
    ]))->assertSuccessful();
});

it('can render account create action', function () {
    livewire(Pages\ManageAccounts::class)
        ->mountAction('create')
        ->assertSuccessful();
});

it('can render account create page', function () {
    get(AccountResource::getUrl('create'))->assertSuccessful();
});

it('can create new account', function () {
    $newData = Account::factory()->make();

    $password = str()->random(10);

    livewire(Pages\CreateAccount::class)
        ->fillForm([
            'name' => $newData->name,
            'email' => $newData->email,
            'phone' => $newData->phone,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Account::class, [
        'name' => $newData->name,
        'email' => $newData->email,
        'phone' => $newData->phone,
    ]);
});

it('can validate account input', function () {
    livewire(Pages\CreateAccount::class)
        ->fillForm([
            'name' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
        ]);
});

it('can render account edit action', function () {
    livewire(Pages\ManageAccounts::class, [
        'record' => Account::factory()->create(),
    ])
        ->mountAction('edit')
        ->assertSuccessful();
});

it('can render account edit page', function () {
    get(AccountResource::getUrl('edit', [
        'record' => Account::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve account data', function () {
    $account = Account::factory()->create();

    livewire(Pages\EditAccount::class, [
        'record' => $account->getRouteKey(),
    ])
        ->assertFormSet([
            'name' => $account->name,
            'email' => $account->email,
        ]);
});

it('can validate edit account input', function () {
    $account = Account::factory()->create();

    livewire(Pages\EditAccount::class, [
        'record' => $account->getRouteKey(),
    ])
        ->fillForm([
            'name' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name' => 'required',
        ]);
});

it('can save account data', function () {
    $account = Account::factory()->create();
    $newData = Account::factory()->make();

    livewire(Pages\EditAccount::class, [
        'record' => $account->getRouteKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
            'email' => $newData->email,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($account->refresh())
        ->name->toBe($newData->name)
        ->email->toBe($newData->email);
});

it('can delete account', function () {
    $account = Account::factory()->create();

    livewire(Pages\EditAccount::class, [
        'record' => $account->getRouteKey(),
    ])
        ->callAction('deleteSelectedAccount');

    assertNotEmpty(Account::query()->withTrashed()->find($account->getRouteKey())->deleted_at);
});
