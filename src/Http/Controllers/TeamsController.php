<?php

namespace TomatoPHP\FilamentAccounts\Http\Controllers;

use App\Http\Controllers\Controller;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Jetstream;

class TeamsController extends Controller
{
    public function accept(Request $request, $invitationId)
    {
        $model = Jetstream::teamInvitationModel();

        $invitation = $model::whereKey($invitationId)->first();

        if($invitation){
            $newTeamMember = Jetstream::findUserByEmailOrFail($invitation->email);

            AddingTeamMember::dispatch($invitation->team, $newTeamMember);

            $invitation->team->users()->attach(
                $newTeamMember, ['role' => $invitation->role]
            );

            TeamMemberAdded::dispatch($invitation->team, $newTeamMember);

            $invitation->delete();

            return redirect()->to(url(Filament::getCurrentPanel()->getId() .'/' . $invitation->team->id));
        }

        return redirect()->to(url(Filament::getCurrentPanel()->getId()));
    }

    public function cancel(Request $request, $invitationId)
    {
        $model = Jetstream::teamInvitationModel();

        $invitation = $model::whereKey($invitationId)->first();

        if($invitation){
            $invitation->delete();
        }

        return redirect()->to(url(Filament::getCurrentPanel()->getId()));
    }
}
