@php
    $account = config('filament-accounts.model')::find($team->owner->id);
@endphp
<!-- Team Owner Information -->
<div class="col-span-6">
    <label>
        {{ trans('filament-accounts::messages.teams.edit.owner') }}
    </label>

    <div class="flex justify-start gap-2 py-4">
        <div class="flex flex-col items-center justify-center">
            <x-filament::avatar
                :src="$account->getFilamentAvatarUrl()?: 'https://ui-avatars.com/api/?name='.$account->name.'&color=FFFFFF&background=020617'"
                :alt="$account->name"
            />
        </div>
        <div class="flex flex-col">
            <div class="font-meduim text-md">
                {{ $account->name }}
            </div>
            <div class="text-xs text-gray-400">
                {{ $account->loginBy === 'email' ? $account->email : $account->phone }}
            </div>
        </div>
    </div>
</div>
