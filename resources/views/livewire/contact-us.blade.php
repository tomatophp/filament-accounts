<div>
    @if(filament()->hasPlugin('filament-saas-accounts') && filament('filament-saas-accounts')->showContactUsButton)
        <div class="border-t dark:border-gray-700 p-4">
            <span class="text-gray-400">{{ trans('filament-accounts::messages.contact-us.footer') }}</span> {{ $this->getContactUsAction }}
        </div>

        <x-filament-actions::modals />
    @endif
</div>
