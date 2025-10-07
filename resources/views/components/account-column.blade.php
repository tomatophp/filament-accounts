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

<style>
    .fi-account-column-link,
    .fi-account-column-container {
        display: flex;
        gap: 0.5rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
        align-items: center;
    }

    .fi-account-column-link {
        transition: opacity 0.2s;
    }

    .fi-account-column-link:hover {
        opacity: 0.8;
    }

    .fi-account-column-avatar {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .fi-account-column-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .fi-account-column-name {
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.25rem;
        color: rgb(17 24 39);
    }

    .fi-account-column-name:where(.dark,.dark *) {
        color: rgb(243 244 246);
    }

    .fi-account-column-contact {
        font-size: 0.75rem;
        line-height: 1rem;
        color: rgb(107 114 128);
    }

    .fi-account-column-contact:where(.dark,.dark *) {
        color: rgb(156 163 175);
    }
</style>

@if($account)
    @if($url)
        <a href="{{ $url }}" class="fi-account-column-link">
            <div class="fi-account-column-avatar">
                <x-filament::avatar
                    :src="$account->getFilamentAvatarUrl()?: 'https://ui-avatars.com/api/?name='.$account->name.'&color=FFFFFF&background=020617'"
                    :alt="$account->name"
                />
            </div>
            <div class="fi-account-column-content">
                <div class="fi-account-column-name">
                    {{ $account->name }}
                </div>
                <div class="fi-account-column-contact">
                    {{ $account->loginBy === 'email' ? $account->email : $account->phone }}
                </div>
            </div>
        </a>
    @else
        <div class="fi-account-column-container">
            <div class="fi-account-column-avatar">
                <x-filament::avatar
                    :src="$account->getFilamentAvatarUrl()?: 'https://ui-avatars.com/api/?name='.$account->name.'&color=FFFFFF&background=020617'"
                    :alt="$account->name"
                />
            </div>
            <div class="fi-account-column-content">
                <div class="fi-account-column-name">
                    {{ $account->name }}
                </div>
                <div class="fi-account-column-contact">
                    {{ $account->loginBy === 'email' ? $account->email : $account->phone }}
                </div>
            </div>
        </div>
    @endif
@endif
