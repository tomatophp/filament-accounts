
<x-filament-panels::page>
    @if(auth('accounts')->user()->id === $team->account_id)
        <x-filament-panels::form wire:submit="saveEditTeam">
            {{ $this->editTeamForm }}

            <x-filament-panels::form.actions
                alignment="right"
                :actions="$this->getEditTeamActions()"
            />

        </x-filament-panels::form>
    @endif
    @if(filament()->getPlugin('filament-saas-accounts')->teamInvitation && auth('accounts')->user()->id === $team->account_id)
        <x-filament-panels::form wire:submit="sendInvitation">
            {{ $this->manageTeamMembersForm }}

            <x-filament-panels::form.actions
                alignment="right"
                :actions="$this->getSendInvitationActions()"
            />

        </x-filament-panels::form>


        @if ($team->teamInvitations->isNotEmpty())
            <x-filament::section
                :heading="__('Team Member Invitations')"
                :description="__('All of the people that are part of this team.')"
            >
                <!-- Team Member Invitations -->
                <div class="mt-10 sm:mt-0">
                    <div class="space-y-6">
                        @foreach ($team->teamInvitations as $invitation)
                            <div class="flex items-center justify-between">
                                <div class="text-gray-600">{{ $invitation->email }}</div>

                                <div class="flex items-center gap-4">
                                    {{ ($this->getResendInvitationAction)(['invitation'=>$invitation->id]) }}
                                    {{ ($this->getCancelTeamInvitationAction)(['invitation'=>$invitation->id]) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-filament::section>
        @endif
    @endif

    @if(filament()->getPlugin('filament-saas-accounts')->showTeamMembers)
        @if ($team->users->isNotEmpty())
            <x-filament::section
                :heading="trans('filament-accounts::messages.teams.members.list.title')"
                :description="trans('filament-accounts::messages.teams.members.list.description')"
            >
                <!-- Team Member Invitations -->
                <div class="mt-10 sm:mt-0">
                    <div class="space-y-6">
                        @foreach ($team->users->sortBy('name') as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex justify-start gap-2">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-filament::avatar
                                            :src="$user->getFilamentAvatarUrl()?: 'https://ui-avatars.com/api/?name='.$user->name.'&color=FFFFFF&background=020617'"
                                            :alt="$user->name"
                                        />
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="font-meduim text-md">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $user->loginBy === 'email' ? $user->email : $user->phone }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <!-- Manage Team Member Role -->
                                    @if (auth('accounts')->user()->id === \Filament\Facades\Filament::getTenant()->account_id && Laravel\Jetstream\Jetstream::hasRoles() && $user->membership->role)
                                        {{ ($this->getManageRoleAction(Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name))(['user' => $user->id, 'role'=>$user->membership->role]) }}
                                    @elseif (Laravel\Jetstream\Jetstream::hasRoles() && $user->membership->role)
                                        <div class="ms-2 text-sm text-gray-400">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                        </div>
                                    @endif

                                    <!-- Leave Team -->
                                    @if (auth('accounts')->user()->id === $user->id)
                                        {{ ($this->getLeavingTeamAction)(['user'=> $user->id]) }}

                                    <!-- Remove Team Member -->
                                    @elseif (auth('accounts')->user()->id === \Filament\Facades\Filament::getTenant()->account_id)
                                        {{ ($this->getRemoveMemberAction)(['user'=> $user->id]) }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-filament::section>
        @endif
    @endif

    @if(filament()->getPlugin('filament-saas-accounts')->deleteTeam && auth('accounts')->user()->id === $team->account_id)
        <x-filament-panels::form wire:submit="deleteTeam">
            {{ $this->deleteTeamFrom }}
        </x-filament-panels::form>
    @endif

    <x-filament-actions::modals />
</x-filament-panels::page>
