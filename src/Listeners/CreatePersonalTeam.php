<?php

namespace TomatoPHP\FilamentAccounts\Listeners;

use Filament\Events\Auth\Registered;

class CreatePersonalTeam
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {

    }
}
