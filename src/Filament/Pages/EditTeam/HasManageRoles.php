<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages\EditTeam;

use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Support\Exceptions\Halt;
use Laravel\Jetstream\Events\TeamMemberUpdated;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Role;

trait HasManageRoles
{
    public function getManageRoleAction($role=null)
    {
        return \Filament\Actions\Action::make('getManageRoleAction')
            ->requiresConfirmation()
            ->link()
            ->color('info')
            ->label($role)
            ->modelLabel(trans('filament-accounts::messages.teams.members.manage_role'))
            ->form(function (array $arguments){
                return [
                    Select::make('role')
                        ->default($arguments['role'])
                        ->label(trans('filament-accounts::messages.teams.members.role'))
                        ->searchable()
                        ->preload()
                        ->options(function (){
                            $roles = collect(Jetstream::$roles)->transform(function ($role) {
                                return with($role->jsonSerialize(), function ($data) {
                                    return (new Role(
                                        $data['key'],
                                        $data['name'],
                                        $data['permissions']
                                    ))->description($data['description']);
                                });
                            })->values();
                            return $roles->pluck('name', 'key');
                        })
                        ->rules(Jetstream::hasRoles()
                            ? ['required', 'string', new \Laravel\Jetstream\Rules\Role]
                            : null,)
                        ->validationMessages([
                            'role.required' => trans('filament-accounts::messages.teams.members.role_required'),
                        ])
                ];
            })
            ->action(function (array $arguments, array $data){
                $this->manageRole($arguments['user'], $data['role']);
            });
    }
    public function manageRole(int $id,string $role)
    {
        try {
            Filament::getTenant()->users()->updateExistingPivot($id, [
                'role' => $role,
            ]);

            TeamMemberUpdated::dispatch(Filament::getTenant()->fresh(), Jetstream::findUserByIdOrFail($id));
        } catch (Halt $exception) {
            return;
        }

        $this->sendSuccessNotification();
    }
}
