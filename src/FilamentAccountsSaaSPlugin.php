<?php

namespace TomatoPHP\FilamentAccounts;

use Filament\Contracts\Plugin;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Laravel\Jetstream\Jetstream;
use TomatoPHP\FilamentAccounts\Filament\Pages\ApiTokens;
use TomatoPHP\FilamentAccounts\Filament\Pages\Auth\LoginAccount;
use TomatoPHP\FilamentAccounts\Filament\Pages\Auth\RegisterAccount;
use TomatoPHP\FilamentAccounts\Filament\Pages\Auth\RegisterAccountWithoutOTP;
use TomatoPHP\FilamentAccounts\Filament\Pages\CreateTeam;
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
        $panel
            ->tenant($this->useJetstreamTeamModel ? Jetstream::teamModel(): Team::class, 'id')
            ->tenantRegistration(CreateTeam::class);

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
                $menuItems[] = MenuItem::make()
                    ->label(fn(): string => EditProfile::getNavigationLabel())
                    ->icon('heroicon-s-user')
                    ->url(fn (): string => EditProfile::getUrl());
            }
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
    public bool $showTeamMembers = false;
    public bool $checkAccountStatusInLogin = false;
    public bool $useOTPActivation = false;

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
