<div>
    @if(filament()->hasPlugin('filament-saas-accounts') && filament('filament-saas-accounts')->showContactUsButton)
        <div class="border-t dark:border-gray-700 p-4">
            <span class="text-gray-400">Do you have any problems or questions? Please</span> {{ $this->getContactUsAction }}
        </div>

        <x-filament-actions::modals />
    @endif
</div>
