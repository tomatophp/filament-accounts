<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages\EditTeam;

use Filament\Support\Exceptions\Halt;
use Laravel\Jetstream\Jetstream;

trait HasCancelTeamInvitation
{
    public function getCancelTeamInvitationAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('getCancelTeamInvitationAction')
            ->requiresConfirmation()
            ->color('danger')
            ->label(trans('filament-accounts::messages.teams.actions.cancel_invitation'))
            ->action(function (array $arguments){
                $this->cancelTeamInvitation($arguments['invitation']);
            });
    }
    public function cancelTeamInvitation($invitationId)
    {
        try {
            if (! empty($invitationId)) {
                $model = Jetstream::teamInvitationModel();

                $model::whereKey($invitationId)->delete();
            }
        } catch (Halt $exception) {
            return;
        }

        $this->sendSuccessNotification();
    }
}
