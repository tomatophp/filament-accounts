<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages\EditTeam;

use Filament\Facades\Filament;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use TomatoPHP\FilamentAccounts\Forms\ManageTeamMembersForm;

trait HasManageTeamMembers
{
    public function manageTeamMembersForm(Form $form): Form
    {
        return $form->schema([
            Section::make(trans('filament-accounts::messages.teams.members.title'))
                ->description(trans('filament-accounts::messages.teams.members.description'))
                ->schema(ManageTeamMembersForm::get(Filament::getTenant()))
        ])
            ->model(Filament::getTenant())
            ->statePath('manageTeamMembersData');
    }
}
