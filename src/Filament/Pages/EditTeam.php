<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditTeam extends EditTenantProfile
{

    protected static ?int $navigationSort = 2;

    /**
     * @return bool
     */
    public static function isShouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getLabel(): string
    {
        return 'Team Settings';
    }

    public function form(Form $form): Form
    {
        return $form->schema([
           TextInput::make('name')->label('Name')->required(),
        ]);
    }

    protected function getViewData(): array
    {
        return [
            'team' => Filament::getTenant(),
        ];
    }
}
