<?php

namespace TomatoPHP\FilamentAccounts\Actions\Jetstream;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;
use TomatoPHP\FilamentAccounts\Models\Account;
use TomatoPHP\FilamentAccounts\Models\Team;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  array<string, string>  $input
     */
    public function create(mixed $user, array $input): Team
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'personal_team' => false,
        ]));

        $user->current_team_id = $team->id;
        $user->teams()->attach([$team->id]);

        return $team;
    }
}
