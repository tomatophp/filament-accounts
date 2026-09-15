<?php

use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\AccountForm;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\InfoList\AccountInfoList;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\CreateAccount;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\ListAccounts;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Pages\ViewAccount;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountActions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountBulkActions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountFilters;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountHeaderActions;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Table\AccountTable;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentAccounts\Tests\Models\Account;
use TomatoPHP\FilamentAccounts\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

/**
 * The resource hooks are static registries; clear them so the feature flags booted here
 * do not leak into the other test files.
 */
function resetAccountResourceHooks(): void
{
    $classes = [
        AccountForm::class,
        AccountInfoList::class,
        AccountTable::class,
        AccountFilters::class,
        AccountActions::class,
        AccountBulkActions::class,
        AccountHeaderActions::class,
    ];

    foreach ($classes as $class) {
        foreach ((new ReflectionClass($class))->getProperties(ReflectionProperty::IS_STATIC) as $property) {
            if (is_array($property->getValue())) {
                $property->setValue(null, []);
            }
        }
    }
}

beforeEach(function () {
    actingAs(User::factory()->create());

    resetAccountResourceHooks();

    FilamentAccountsPlugin::make()
        ->useTypes()
        ->useAvatar()
        ->useExport()
        ->useImport()
        ->canLogin()
        ->canBlocked()
        ->useLoginBy()
        ->showAddressField()
        ->useImpersonate()
        ->boot(Filament::getCurrentOrDefaultPanel());
});

afterEach(function () {
    resetAccountResourceHooks();
});

it('renders the accounts table with every feature enabled', function () {
    Account::factory()->count(3)->create();

    livewire(ListAccounts::class)
        ->loadTable()
        ->assertSuccessful()
        ->assertTableColumnExists('type');
});

it('registers the export and import header actions', function () {
    livewire(ListAccounts::class)
        ->assertActionExists(TestAction::make('export')->table())
        ->assertActionExists(TestAction::make('import')->table());
});

it('exports accounts as csv', function () {
    Account::factory()->count(2)->create();

    livewire(ListAccounts::class)
        ->callAction(TestAction::make('export')->table())
        ->assertFileDownloaded('accounts.csv');
});

it('changes an account password', function () {
    $account = Account::factory()->create();

    livewire(ListAccounts::class)
        ->callAction(TestAction::make('password')->table($account), data: [
            'password' => 'new-secret-123',
            'password_confirmation' => 'new-secret-123',
        ])
        ->assertHasNoFormErrors();

    expect(Hash::check('new-secret-123', $account->refresh()->password))->toBeTrue();
});

it('shows the impersonate action for accounts', function () {
    $account = Account::factory()->create();

    livewire(ListAccounts::class)
        ->assertActionVisible(TestAction::make('impersonate')->table($account));
});

it('renders the create and view pages with every feature field', function () {
    livewire(CreateAccount::class)
        ->assertSuccessful()
        ->assertFormFieldExists('type')
        ->assertFormFieldExists('avatar');

    livewire(ViewAccount::class, [
        'record' => Account::factory()->create()->getRouteKey(),
    ])->assertSuccessful();
});
