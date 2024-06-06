<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages\EditTeam;

use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentAccounts\Forms\UpdateTeamForm;

trait HasEditTeam
{
    public function editTeamForm(Form $form): Form
    {
        return $form->schema([
            Section::make(trans('filament-accounts::messages.teams.edit.title'))
                ->description(trans('filament-accounts::messages.teams.edit.description'))
                ->schema(UpdateTeamForm::get(Filament::getTenant()))
        ])
            ->model(Filament::getTenant())
            ->statePath('editTeamData');
    }
    public function getEditTeamActions(): array
    {
        return [
            Action::make('editTeam')
                ->requiresConfirmation()
                ->label(trans('filament-accounts::messages.teams.edit.save'))
                ->submit('editTeamForm')
                ->color('primary')
        ];
    }
    public function saveEditTeam()
    {
        try {
            $data = $this->editTeamForm->getState();

            $this->handleRecordUpdate(Filament::getTenant(), $data);
        } catch (Halt $exception) {
            return;
        }

        $this->sendSuccessNotification();
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }
}
