<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages\EditProfile;

use Filament\Forms\Form;
use TomatoPHP\FilamentAccounts\Forms\DeleteAccountForm;

trait HasDeleteAccount
{
    public function deleteAccountForm(Form $form): Form
    {
        return $form
            ->schema(DeleteAccountForm::get())
            ->model($this->getUser())
            ->statePath('deleteAccountData');
    }
}
