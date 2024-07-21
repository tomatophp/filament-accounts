<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;

class CreateTeam extends RegisterTenant
{
    public static function registerNavigationItems()
    {
        return [];
    }

    public static function getCluster()
    {

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
                    ->avatar()
                    ->collection('avatar'),
                TextInput::make('name')
                    ->default(auth('accounts')->user()->teams()->count() > 0 ? null :auth('accounts')->user()->name . "'s Team"),
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        $newTeam = app(\TomatoPHP\FilamentAccounts\Actions\Jetstream\CreateTeam::class)->create(auth(filament()->getPlugin('filament-saas-accounts')->authGuard)->user(), $data);
        return $newTeam;
    }
}
