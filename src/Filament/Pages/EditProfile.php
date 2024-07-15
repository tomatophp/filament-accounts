<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Models\Contracts\HasTenants;
use Filament\Pages\Dashboard;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentAccounts\Filament\Pages\EditProfile\HasBrowserSessions;
use TomatoPHP\FilamentAccounts\Filament\Pages\EditProfile\HasDeleteAccount;
use TomatoPHP\FilamentAccounts\Filament\Pages\EditProfile\HasEditPassword;
use TomatoPHP\FilamentAccounts\Filament\Pages\EditProfile\HasEditProfile;
use TomatoPHP\FilamentAccounts\Forms\BrowserSessionsForm;
use TomatoPHP\FilamentAccounts\Forms\CustomFieldsForm;
use TomatoPHP\FilamentAccounts\Forms\DeleteAccountForm;
use TomatoPHP\FilamentAccounts\Forms\EditPasswordForm;
use TomatoPHP\FilamentAccounts\Forms\EditProfileForm;
use App\Filament\App\Pages\Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Auth\Authenticatable;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    use HasEditProfile;
    use HasEditPassword;
    use HasBrowserSessions;
    use HasDeleteAccount;

    protected static string $view = 'filament-accounts::teams.edit-profile';

    protected ?string $maxWidth = '6xl';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return  trans('filament-accounts::messages.profile.title');
    }

    public static function getNavigationLabel(): string
    {
        return  trans('filament-accounts::messages.profile.title');
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public static function shouldShowDeleteAccountForm()
    {
        return true;
    }

    public static function shouldShowBrowserSessionsForm()
    {
        return true;
    }

    public static function shouldShowSanctumTokens()
    {
        return true;
    }

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm',
            'deleteAccountForm',
            'browserSessionsForm',
        ];
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }

    public function getUser()
    {
        return auth(filament()->getPlugin('filament-saas-accounts')->authGuard)->user();
    }

    public function sendSuccessNotification()
    {
        Notification::make()
            ->title("Success")
            ->success()
            ->send();
    }
}
