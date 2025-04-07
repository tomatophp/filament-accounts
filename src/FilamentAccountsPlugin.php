<?php

namespace TomatoPHP\FilamentAccounts;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\Config;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;
use TomatoPHP\FilamentTypes\Facades\FilamentTypes;
use TomatoPHP\FilamentTypes\Services\Contracts\Type;
use TomatoPHP\FilamentTypes\Services\Contracts\TypeFor;
use TomatoPHP\FilamentTypes\Services\Contracts\TypeOf;

class FilamentAccountsPlugin implements Plugin
{
    public bool $useTeams = false;

    public bool $useNotifications = false;

    public bool $useTypes = false;

    public bool $useLoginBy = false;

    public bool $useAvatar = false;

    public bool $useExport = false;

    public bool $useImport = false;

    public bool $showAddressField = false;

    public bool $showTypeField = false;

    public bool $canLogin = false;

    public bool $canBlocked = false;

    public bool $useImpersonate = false;

    public bool $useResource = true;

    public ?string $impersonateRedirect = '/app';

    public function getId(): string
    {
        return 'filament-accounts';
    }

    public function register(Panel $panel): void
    {
        $resources = [
            AccountResource::class,
        ];

        if ($this->useTypes) {
            $panel->pages([
                AccountResource\Pages\AccountTypes::class,
            ]);
        }

        if ($this->useResource) {
            $panel->resources($resources);
        }

    }

    public function useExport(bool $useExport = true): static
    {
        $this->useExport = $useExport;

        return $this;
    }

    public function useResource(bool $useResource = true): static
    {
        $this->useResource = $useResource;

        return $this;
    }

    public function useImport(bool $useImport = true): static
    {
        $this->useImport = $useImport;

        return $this;
    }

    public function useTeams(bool $useTeams = true): static
    {
        $this->useTeams = $useTeams;

        return $this;
    }

    public function useNotifications(bool $useNotifications = true): static
    {
        $this->useNotifications = $useNotifications;

        return $this;
    }

    public function useTypes(bool $useTypes = true): static
    {
        $this->useTypes = $useTypes;

        return $this;
    }

    public function useAvatar(bool $useAvatar = true): static
    {
        $this->useAvatar = $useAvatar;

        return $this;
    }

    public function useLoginBy(bool $useLoginBy = true): static
    {
        $this->useLoginBy = $useLoginBy;

        return $this;
    }

    public function showAddressField(bool $showAddressField = true): static
    {
        $this->showAddressField = $showAddressField;

        return $this;
    }

    public function canLogin(bool $canLogin = true): static
    {
        $this->canLogin = $canLogin;

        return $this;
    }

    public function canBlocked(bool $canBlocked = true): static
    {
        $this->canBlocked = $canBlocked;

        return $this;
    }

    public function useImpersonate(bool $useImpersonate = true): static
    {
        $this->useImpersonate = $useImpersonate;

        return $this;
    }

    public function impersonateRedirect(?string $impersonateRedirect): static
    {
        $this->impersonateRedirect = $impersonateRedirect;

        return $this;
    }

    public function showTypeField(bool $showTypeField = true): static
    {
        $this->showTypeField = $showTypeField;

        return $this;
    }

    public function boot(Panel $panel): void
    {
        Config::set('filament-accounts.features.notifications', $this->useNotifications);
        Config::set('filament-accounts.features.loginBy', $this->useLoginBy);
        Config::set('filament-accounts.features.types', $this->useTypes);
        Config::set('filament-accounts.features.avatar', $this->useAvatar);
        Config::set('filament-accounts.features.impersonate.active', $this->useImpersonate);
        Config::set('filament-accounts.features.impersonate.redirect', $this->impersonateRedirect);

        if ($this->showAddressField) {
            AccountResource\Form\AccountForm::register(AccountResource\Form\Components\Address::make());
            AccountResource\InfoList\AccountInfoList::register(AccountResource\InfoList\Entries\Address::make());
        }

        if ($this->useAvatar) {
            AccountResource\Form\AccountForm::register(AccountResource\Form\Components\Avatar::make());
            AccountResource\InfoList\AccountInfoList::register(AccountResource\InfoList\Entries\Avatar::make());
            AccountResource\Table\AccountTable::register(AccountResource\Table\Columns\Account::make());
        }

        if ($this->useTypes) {
            FilamentTypes::register(
                TypeFor::make('accounts')
                    ->label('Accounts')
                    ->types([
                        TypeOf::make('type')
                            ->label('Type')
                            ->register([
                                Type::make('customer')
                                    ->name([
                                        'ar' => 'عميل',
                                        'en' => 'Customer',
                                    ])
                                    ->icon('heroicon-c-user-group')
                                    ->color('#d91919'),
                                Type::make('account')
                                    ->name([
                                        'ar' => 'حساب',
                                        'en' => 'Account',
                                    ])
                                    ->icon('heroicon-c-user-circle')
                                    ->color('#0a56d9'),
                            ]),
                    ])
            );
            AccountResource\Table\AccountFilters::register(AccountResource\Table\Filters\Type::make());
            AccountResource\Form\AccountForm::register(AccountResource\Form\Components\Type::make());
            AccountResource\Table\AccountTable::register(AccountResource\Table\Columns\Type::make());
            AccountResource\InfoList\AccountInfoList::register(AccountResource\InfoList\Entries\Type::make());
            AccountResource\Actions\ManagePageActions::register(AccountResource\Actions\Components\TypesAction::make());
        }

        if ($this->canLogin) {
            AccountResource\Table\AccountFilters::register(AccountResource\Table\Filters\IsLogin::make());
            AccountResource\Form\AccountForm::register(AccountResource\Form\Components\IsLogin::make());
            AccountResource\Form\AccountForm::register(AccountResource\Form\Components\Password::make());
            AccountResource\Form\AccountForm::register(AccountResource\Form\Components\PasswordConfirmation::make());
            AccountResource\Table\AccountTable::register(AccountResource\Table\Columns\IsLogin::make());
            AccountResource\Table\AccountActions::register(AccountResource\Table\Actions\ChangePasswordAction::make());
            AccountResource\InfoList\AccountInfoList::register(AccountResource\InfoList\Entries\IsLogin::make());
        }

        if ($this->canBlocked) {
            AccountResource\Table\AccountFilters::register(AccountResource\Table\Filters\IsActive::make());
            AccountResource\Form\AccountForm::register(AccountResource\Form\Components\IsActive::make());
            AccountResource\Table\AccountTable::register(AccountResource\Table\Columns\IsActive::make());
            AccountResource\InfoList\AccountInfoList::register(AccountResource\InfoList\Entries\IsActive::make());
        }

        if ($this->useLoginBy) {
            AccountResource\Form\AccountForm::register(AccountResource\Form\Components\LoginBy::make());
            AccountResource\InfoList\AccountInfoList::register(AccountResource\InfoList\Entries\LoginBy::make());
        }

        if ($this->useExport) {
            AccountResource\Table\AccountHeaderActions::register(AccountResource\Table\HeaderActions\ExportAction::make());
        }

        if ($this->useImport) {
            AccountResource\Table\AccountHeaderActions::register(AccountResource\Table\HeaderActions\ImportAction::make());
        }

        if ($this->useImpersonate) {
            AccountResource\Table\AccountActions::register(AccountResource\Table\Actions\ImpersonateAction::make());
        }
    }

    public static function make(): FilamentAccountsPlugin
    {
        return new FilamentAccountsPlugin;
    }
}
