<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages\EditTeam;

use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;

trait HasTeamInvitation
{
    public function getSendInvitationActions(): array
    {
        return [
            Action::make('sendInvitation')
                ->label(trans('filament-accounts::messages.teams.members.send_invitation'))
                ->submit('manageTeamMembersForm')
                ->color('primary')
        ];
    }
    public function getResendInvitationAction()
    {
        return \Filament\Actions\Action::make('getResendInvitationAction')
            ->requiresConfirmation()
            ->color('warning')
            ->label(trans('filament-accounts::messages.teams.actions.resend_invitation'))
            ->action(function (array $arguments){
                $this->resendTeamInvitation($arguments['invitation']);
            });
    }
    public function resendTeamInvitation($invitationId)
    {
        try {
            $model = Jetstream::teamInvitationModel();

            $invitation = $model::whereKey($invitationId)->first();

            Mail::to($invitation->email)->send(new TeamInvitation($invitation));

            $account = config('filament-accounts.model')::where('email', $invitation->email)->first();

            if($account){
                Notification::make()
                    ->title(trans('filament-accounts::messages.teams.members.notifications.title'))
                    ->body(trans('filament-accounts::messages.teams.members.notifications.body', ['team' => $invitation->team->name]))
                    ->success()
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('acceptInvitation')
                            ->label(trans('filament-accounts::messages.teams.members.notifications.accept'))
                            ->color('success')
                            ->markAsRead()
                            ->url(route('accounts.team-invitations.accept', ['invitation' => $invitation->id])),
                        \Filament\Notifications\Actions\Action::make('cancelInvitation')
                            ->label(trans('filament-accounts::messages.teams.members.notifications.cancel'))
                            ->color('danger')
                            ->url(route('accounts.team-invitations.cancel', ['invitation' => $invitation->id])),
                    ])
                    ->sendToDatabase($account);
            }
        } catch (Halt $exception) {
            return;
        }

        $this->sendSuccessNotification();
    }
    public function sendInvitation()
    {
        try {
            $data = $this->manageTeamMembersForm->getState();
            $this->manageTeamInvitations(Filament::getTenant(), $data);
        } catch (Halt $exception) {
            return;
        }

        $this->sendSuccessNotification();
    }
    protected function manageTeamInvitations(Model $record, array $data)
    {
        $user = auth(filament()->getPlugin('filament-saas-accounts')->authGuard)->user();
        $team = $record;
        $email = $data['email'];
        $role = $data['role'];

        InvitingTeamMember::dispatch($team, $email, $role);

        $invitation = $team->teamInvitations()->create([
            'email' => $email,
            'role' => $role,
        ]);

        Mail::to($email)->send(new TeamInvitation($invitation));

        $account = config('filament-accounts.model')::where('email', $email)->first();

        if($account){
            Notification::make()
                ->title(trans('filament-accounts::messages.teams.members.notifications.title'))
                ->body(trans('filament-accounts::messages.teams.members.notifications.body', ['team' => $team->name]))
                ->success()
                ->actions([
                    \Filament\Notifications\Actions\Action::make('acceptInvitation')
                        ->label(trans('filament-accounts::messages.teams.members.notifications.accept'))
                        ->color('success')
                        ->markAsRead()
                        ->url(route('accounts.team-invitations.accept', ['invitation' => $invitation->id])),
                    \Filament\Notifications\Actions\Action::make('cancelInvitation')
                        ->label(trans('filament-accounts::messages.teams.members.notifications.cancel'))
                        ->color('danger')
                        ->url(route('accounts.team-invitations.cancel', ['invitation' => $invitation->id])),
                ])
                ->sendToDatabase($account);
        }

    }
}
