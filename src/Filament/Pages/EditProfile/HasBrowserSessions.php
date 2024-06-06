<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages\EditProfile;

use Filament\Forms\Form;
use TomatoPHP\FilamentAccounts\Forms\BrowserSessionsForm;

trait HasBrowserSessions
{
    public function browserSessionsForm(Form $form): Form
    {
        return $form
            ->schema(BrowserSessionsForm::get());
    }
}
