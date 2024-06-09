<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages\EditTeam;

use Filament\Facades\Filament;
use Filament\Support\Exceptions\Halt;
use Laravel\Jetstream\Events\TeamMemberRemoved;

trait HasLeavingTeam
{
    public function getLeavingTeamAction()
    {
        return \Filament\Actions\Action::make('getLeavingTeamAction')
            ->requiresConfirmation()
            ->link()
            ->color('danger')
            ->label(trans('filament-accounts::messages.teams.members.leave_team'))
            ->action(function (array $arguments){
                $this->removeMember($arguments['user']);
            });
    }
    public function getRemoveMemberAction()
    {
        return \Filament\Actions\Action::make('getRemoveMemberAction')
            ->requiresConfirmation()
            ->link()
            ->color('danger')
            ->label(trans('filament-accounts::messages.teams.members.remove_member'))
            ->action(function (array $arguments){
                $this->removeMember($arguments['user']);
            });
    }
    public function removeMember($user)
    {
        $teamMember = config('filament-accounts.model')::find($user);
        try {
            Filament::getTenant()->removeUser($teamMember);
            TeamMemberRemoved::dispatch(Filament::getTenant(), $teamMember);
        } catch (Halt $exception) {
            return;
        }

        $this->sendSuccessNotification();

        return redirect()->to(Filament::getCurrentPanel()->getUrl());
    }
}
