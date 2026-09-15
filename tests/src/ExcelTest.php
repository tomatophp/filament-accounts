<?php

use TomatoPHP\FilamentAccounts\Export\ExportAccounts;
use TomatoPHP\FilamentAccounts\Import\ImportAccounts;
use TomatoPHP\FilamentAccounts\Tests\Models\Account;

use function Pest\Laravel\assertDatabaseHas;

it('exports the selected account columns', function () {
    Account::factory()->count(3)->create();

    $export = new ExportAccounts([
        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
        ],
    ]);

    $rows = $export->collection();

    expect($export->headings())->toBe(['ID', 'Name', 'Email'])
        ->and($rows)->toHaveCount(3)
        ->and($rows->first()->keys()->all())->toBe(['id', 'name', 'email']);
});

it('imports accounts and skips the heading row', function () {
    (new ImportAccounts)->collection(collect([
        collect([trans('filament-accounts::messages.accounts.columns.id'), 'Name', 'Email', 'Phone', 'Address', 'Type', 'Active']),
        collect([null, 'Jane Doe', 'jane@example.com', '+201000000000', 'Cairo', 'customer', 1]),
    ]));

    assertDatabaseHas('accounts', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+201000000000',
        'type' => 'customer',
    ]);

    expect(Account::query()->count())->toBe(1);
});
