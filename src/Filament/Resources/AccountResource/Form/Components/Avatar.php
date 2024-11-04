<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountResource\Form\Components;

use Filament\Forms;

class Avatar extends Component
{
    public static function make(): Forms\Components\Field
    {
        return Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
            ->alignCenter()
            ->collection('avatar')
            ->columnSpan(2)
            ->label(trans('filament-accounts::messages.accounts.columns.avatar'));
    }
}
