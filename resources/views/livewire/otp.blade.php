<div class="fi-simple-page">
    <section class="grid auto-cols-fr gap-y-6">
        <x-filament-panels::header.simple
            :heading="$this->getHeading()"
            :logo="true"
            :subheading="$this->getSubHeading()"
        />

        <x-filament-panels::form wire:submit="authenticate">
            {{ $this->form }}

            <div
                class="fi-form-actions"
            >
                <x-filament::actions
                    :actions="$this->getCachedFormActions()"
                    alignment="center"
                />
            </div>
        </x-filament-panels::form>
    </section>
</div>
