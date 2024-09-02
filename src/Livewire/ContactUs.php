<?php

namespace TomatoPHP\FilamentAccounts\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use TomatoPHP\FilamentAccounts\Models\Contact;

class ContactUs extends Component implements HasForms,HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function render(): View
    {
        return view('filament-accounts::livewire.contact-us');
    }

    public function getContactUsAction(): Action
    {
        return Action::make('getContactUsAction')
            ->link()
            ->modalHeading('Please Fill This Form To Contact Us')
            ->form([
                Grid::make([
                    "md" => 2,
                    "sm" => 1
                ])->schema([
                    TextInput::make('name')
                        ->autofocus()
                        ->required()
                        ->columnSpan(2),
                    TextInput::make('email')
                        ->email()
                        ->required(),
                    TextInput::make('phone')
                        ->tel()
                        ->required(),
                    TextInput::make('subject')
                        ->required()
                        ->columnSpan(2),
                    Textarea::make('message')
                        ->autosize()
                        ->required()
                        ->columnSpan(2),
                ])
            ])
            ->label('Contact Us')
            ->action(function(array $data){
                // Send email to admin
                Contact::query()->create($data);

                Notification::make()
                    ->title('Contact Us')
                    ->body('Your message has been sent successfully')
                    ->success()
                    ->send();
            });
    }
}
