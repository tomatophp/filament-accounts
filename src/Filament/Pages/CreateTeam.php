<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;

class CreateTeam extends RegisterTenant
{

    /**
     * @return bool
     */
    public static function isShouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getLabel(): string
    {
        return 'Create Team';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('avatar')
                    ->collection('avatar'),
                TextInput::make('name'),
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        return app(\TomatoPHP\FilamentAccounts\Actions\Jetstream\CreateTeam::class)->create(auth('accounts')->user(), $data);
    }
}
