<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <div class="text-start">
            <div class="mt-4 text-sm text-gray-600">
                {{ trans('filament-accounts::messages.profile.delete-team.body') }}
            </div>
        </div>
    </div>
</x-dynamic-component>
