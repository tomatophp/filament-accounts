@php
    $account = config('filament-accounts.model')::withTrashed()->find($getState());
    $tenent = \Filament\Facades\Filament::getTenant()?->id;
    $panel = \Filament\Facades\Filament::getCurrentPanel()->getId() ?? null;
    if(isset(\TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource::getPages()['edit'])){
        $url = \TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource::getUrl('edit', ['record' => $account, 'tenant' => $tenent]);
    }
    else {
        $url = null;
    }

@endphp

@if($account)
    @if($url)
        <a href="{{ $url }}" class="flex justify-start gap-2 py-4">
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
        </a>
    @else
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
    @endif
@endif
