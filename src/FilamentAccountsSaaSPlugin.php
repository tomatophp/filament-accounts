<?php

namespace TomatoPHP\FilamentAccounts;

use Filament\Contracts\Plugin;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Laravel\Jetstream\Jetstream;
use TomatoPHP\FilamentAccounts\Filament\Pages\AccountRequest;
use TomatoPHP\FilamentAccounts\Filament\Pages\ApiTokens;
use TomatoPHP\FilamentAccounts\Filament\Pages\Auth\LoginAccount;
use TomatoPHP\FilamentAccounts\Filament\Pages\Auth\RegisterAccount;
use TomatoPHP\FilamentAccounts\Filament\Pages\Auth\RegisterAccountWithoutOTP;
use TomatoPHP\FilamentAccounts\Filament\Pages\CreateTeam;
use TomatoPHP\FilamentAccounts\Filament\Pages\EditAddress;
use TomatoPHP\FilamentAccounts\Filament\Pages\EditProfile;
use TomatoPHP\FilamentAccounts\Filament\Pages\EditTeam;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource;
use TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource;
use TomatoPHP\FilamentAccounts\Filament\Resources\ContactResource;
use TomatoPHP\FilamentAccounts\Models\Team;
use TomatoPHP\FilamentPlugins\Facades\FilamentPlugins;

class FilamentAccountsSaaSPlugin implements Plugin
{

    public function getId(): string
    {
        return 'filament-saas-accounts';
    }

    public function register(Panel $panel): void
    {
        if($this->allowTenants){
            $panel
                ->tenant($this->useJetstreamTeamModel ? Jetstream::teamModel(): Team::class, 'id')
                ->tenantRegistration(CreateTeam::class);
        }

        $pages = [
            CreateTeam::class
        ];

        $menuItems = [];

        if($this->databaseNotifications){
            $panel->databaseNotifications();
        }

        if($this->editProfile){
            $pages[] = EditProfile::class;

            if($this->editProfileMenu){
                $panel->userMenuItems([
                    "profile" => MenuItem::make()
                        ->label(fn(): string => auth('accounts')->user()?->name)
                        ->icon('heroicon-s-user')
                        ->url(fn (): string => EditProfile::getUrl())
                ]);
            }
        }

        if($this->canManageAddress){
            $pages[] = EditAddress::class;
            $menuItems[] = MenuItem::make()
                ->label(fn(): string => EditAddress::getNavigationLabel())
                ->icon('heroicon-s-map-pin')
                ->url(fn (): string => EditAddress::getUrl());
        }

        if($this->canManageRequests){
            $pages[] = AccountRequest::class;
            $menuItems[] = MenuItem::make()
                ->label(fn(): string => AccountRequest::getNavigationLabel())
                ->icon('heroicon-s-rectangle-stack')
                ->url(fn (): string => AccountRequest::getUrl());
        }

        if($this->APITokenManager){
            $pages[] = ApiTokens::class;

            if($this->editProfileMenu){
                $menuItems[] = MenuItem::make()
                    ->label(fn(): string => ApiTokens::getNavigationLabel())
                    ->icon('heroicon-s-lock-closed')
                    ->url(fn (): string => ApiTokens::getUrl());
            }
        }

        if($this->editTeam){
            $panel->livewireComponents([
                EditTeam::class
            ]);
            $panel->tenantProfile(EditTeam::class);
        }

        if($this->checkAccountStatusInLogin){
            $panel->login(LoginAccount::class);
        }


        if($this->registration){
            $panel->registration(RegisterAccountWithoutOTP::class);
        }

        if($this->useOTPActivation){
            $panel->registration(RegisterAccount::class);
        }

        if($this->showContactUsButton){
            FilamentView::registerRenderHook(
                PanelsRenderHook::FOOTER,
                fn (): string => Blade::render('@livewire(\'tomato-contact-us-form\')')
            );
        }

        $panel->tenantMenuItems($menuItems)
            ->authGuard($this->authGuard)
            ->pages($pages);

    }

    public ?string $authGuard = 'accounts';
    public bool $databaseNotifications = false;
    public bool $editProfileMenu = false;
    public bool $APITokenManager = false;
    public bool $editTeam = false;
    public bool $editProfile = false;
    public bool $editPassword = false;
    public bool $deleteAccount = false;
    public bool $browserSesstionManager = false;
    public bool $registration = false;
    public bool $useJetstreamTeamModel = false;
    public bool $teamInvitation = false;
    public bool $deleteTeam = false;
    public bool $allowTenants = false;
    public bool $showTeamMembers = false;
    public bool $checkAccountStatusInLogin = false;
    public bool $useOTPActivation = false;
    public bool $canManageAddress = false;
    public bool $canManageRequests = false;
    public array $requestsForm = [];
    public bool $showContactUsButton = false;
    public bool $useTypes = false;

    public function allowTenants(bool $allowTenants = true): static
    {
        $this->allowTenants = $allowTenants;
        return $this;
    }

    public function useTypes(bool $useTypes = true): static
    {
        $this->useTypes = $useTypes;
        return $this;
    }

    public function showContactUsButton(bool $showContactUsButton = true): static
    {
        $this->showContactUsButton = $showContactUsButton;
        return $this;
    }

    public function canManageRequests(bool $canManageRequests = true, array $form = []): static
    {
        $this->canManageRequests = $canManageRequests;
        $this->requestsForm = $form;
        return $this;
    }

    public function canManageAddress(bool $canManageAddress = true): static
    {
        $this->canManageAddress = $canManageAddress;
        return $this;
    }

    public function authGuard(string $authGuard): static
    {
        $this->authGuard = $authGuard;
        return $this;
    }

    public function useOTPActivation(bool $useOTPActivation = true): static
    {
        $this->useOTPActivation = $useOTPActivation;
        return $this;
    }

    public function checkAccountStatusInLogin(bool $checkAccountStatusInLogin = true): static
    {
        $this->checkAccountStatusInLogin = $checkAccountStatusInLogin;
        return $this;
    }

    public function showTeamMembers(bool $showTeamMembers = true): static
    {
        $this->showTeamMembers = $showTeamMembers;
        return $this;
    }

    public function teamInvitation(bool $teamInvitation = true): static
    {
        $this->teamInvitation = $teamInvitation;
        return $this;
    }

    public function deleteTeam(bool $deleteTeam = true): static
    {
        $this->deleteTeam = $deleteTeam;
        return $this;
    }

    public function useJetstreamTeamModel(bool $useJetstreamTeamModel = true): static
    {
        $this->useJetstreamTeamModel = $useJetstreamTeamModel;
        return $this;
    }

    public function databaseNotifications(bool $databaseNotifications = true): static
    {
        $this->databaseNotifications = $databaseNotifications;
        return $this;
    }

    public function editProfileMenu(bool $editProfileMenu = true): static
    {
        $this->editProfileMenu = $editProfileMenu;
        return $this;
    }

    public function APITokenManager(bool $APITokenManager = true): static
    {
        $this->APITokenManager = $APITokenManager;
        return $this;
    }

    public function editTeam(bool $editTeam = true): static
    {
        $this->editTeam = $editTeam;
        return $this;
    }

    public function editProfile(bool $editProfile = true): static
    {
        $this->editProfile = $editProfile;
        return $this;
    }

    public function editPassword(bool $editPassword = true): static
    {
        $this->editPassword = $editPassword;
        return $this;
    }


    public function deleteAccount(bool $deleteAccount = true): static
    {
        $this->deleteAccount = $deleteAccount;
        return $this;
    }

    public function browserSesstionManager(bool $browserSesstionManager = true): static
    {
        $this->browserSesstionManager = $browserSesstionManager;
        return $this;
    }

    public function registration(bool $registration = true): static
    {
        $this->registration = $registration;
        return $this;
    }

    public function boot(Panel $panel): void
    {

    }

    public static function make(): static
    {
        return new static();
    }
}
