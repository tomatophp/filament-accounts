<?php

namespace TomatoPHP\FilamentAccounts\Livewire;

use App\Models\Account;
use Carbon\Carbon;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use TomatoPHP\FilamentAccounts\Events\SendOTP;

class Otp extends SimplePage implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;
    use InteractsWithFormActions;
    use WithRateLimiting;

    protected static string $view = 'filament-accounts::livewire.otp';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        if (filament()->auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }
        if(!request()->has('email')){
            redirect()->to('/login');
        }

        $this->data['email'] = request()->get('email');
        $this->form->fill([
            'email' => request()->get('email')
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('email'),
            TextInput::make('otp')
                ->hint('Don\'t receive the code?')
                ->hintAction($this->getResendFormAction())
                ->label('OTP Code')
                ->numeric()
                ->maxLength(6)
                ->autocomplete('current-password')
                ->required()
                ->extraInputAttributes(['tabindex' => 2])
        ])->statePath('data');
    }

    public function resend()
    {
        try {
            $this->rateLimit(1);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $findAccountWithEmail = Account::query()
            ->where('email', $this->data['email'])
            ->first();

        if(!$findAccountWithEmail){
            $this->throwFailureOtpException();
        }

        $findAccountWithEmail->otp_code = rand(100000, 999999);
        $findAccountWithEmail->save();

        event(new SendOTP(config('filament-accounts.model'), $findAccountWithEmail->id));

        Notification::make()
            ->title('OTP Send')
            ->body('OTP code has been sent to your email address.')
            ->success()
            ->send();
    }

    public function authenticate()
    {
        try {
            $this->rateLimit(20);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $findAccountWithEmailAndOTP = Account::query()
            ->where('email', $data['email'])
            ->where('otp_code', $data['otp'])
            ->first();


        if(!$findAccountWithEmailAndOTP){
            $this->throwFailureOtpException();
        }

        Auth::guard('accounts')->login($findAccountWithEmailAndOTP);

        $user = auth()->user();

        if($user){
            $user->otp_code = null;
            $user->otp_activated_at = Carbon::now();
            $user->is_active = true;
            $user->last_login = Carbon::now();
            $user->save();
        }

        session()->regenerate();

        return redirect()->to('/app');
    }

    protected function throwFailureOtpException(): never
    {
        throw ValidationException::withMessages([
            'data.otp' => "otp not correct",
        ]);
    }

    public function getTitle(): string | Htmlable
    {
        return "OTP Authentication";
    }

    public function getSubHeading(): string
    {
        return "Please enter the OTP code sent to your email address.";
    }

    public function getHeading(): string | Htmlable
    {
        return "OTP Authentication";
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
        ];
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label('Verify OTP')
            ->submit('authenticate');
    }

    protected function getResendFormAction(): \Filament\Forms\Components\Actions\Action
    {
        return \Filament\Forms\Components\Actions\Action::make('getResendFormAction')
            ->link()
            ->label('Resend OTP')
            ->color('warning')
            ->action('resend');
    }


    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'otp_code' => $data['otp'],
        ];
    }
}
