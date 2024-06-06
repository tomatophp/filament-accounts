<?php

namespace TomatoPHP\FilamentAccounts\Livewire;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Facades\Filament;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Laravel\Sanctum\Sanctum;
use Livewire\Component;

class SanctumTokens extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public $user;

    public ?string $plainTextToken;

    public function mount()
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
    }

    public function table(Table $table): Table
    {
        $auth = Filament::getCurrentPanel()->auth();

        return $table
            ->query(app(Sanctum::$personalAccessTokenModel)->where([
                ['tokenable_id', '=', $auth->id()],
                ['tokenable_type', '=', get_class($auth->user())],
            ]))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-accounts::messages.profile.token.name')),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->label(trans('filament-accounts::messages.profile.token.created_at'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->color(fn ($record) => now()->gt($record->expires_at) ? 'danger' : null)
                    ->date()
                    ->label(trans('filament-accounts::messages.profile.token.expires_at'))
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(trans('filament-accounts::messages.profile.token.action_label'))
                    ->modalWidth('md')
                    ->form([
                        TextInput::make('token_name')
                            ->label(trans('filament-accounts::messages.profile.token.name'))
                            ->required(),
                        CheckboxList::make('abilities')
                            ->label(trans('filament-accounts::messages.profile.token.abilities'))
                            ->options(function(){
                                return collect(['create', 'view', 'update', 'delete'])->mapWithKeys(function ($item, $key) {
                                    $key = is_string($key) ? $key : strtolower($item);

                                    return [$key => $item];
                                })->toArray();
                            })
                            ->columns(2)
                            ->required(),
                        DatePicker::make('expires_at')
                            ->label(trans('filament-accounts::messages.profile.token.expires_at')),
                    ])
                    ->action(function ($data) {
                        $this->plainTextToken = $this->user->createToken(
                            $data['token_name'],
                            array_values($data['abilities']),
                            $data['expires_at'] ? Carbon::createFromFormat('Y-m-d', $data['expires_at']) : null
                        )->plainTextToken;

                        $this->replaceMountedAction('showToken', [
                            'token' => $this->plainTextToken,
                        ]);

                        Notification::make()
                            ->success()
                            ->title(trans('filament-accounts::messages.profile.token.create_notification'))
                            ->send();
                    })
                    ->modalHeading(trans('filament-accounts::messages.profile.token.modal_heading')),
            ])
            ->emptyStateHeading(trans('filament-accounts::messages.profile.token.empty_state_heading'))
            ->emptyStateDescription(trans('filament-accounts::messages.profile.token.empty_state_description'));
    }

    public function showTokenAction(): Action
    {
        return Action::make('token')
            ->fillForm(fn (array $arguments) => [
                'token' => $arguments['token'],
            ])
            ->form([
                TextInput::make('token')
                    ->label(trans('filament-accounts::messages.profile.token.token'))
                    ->helperText(trans('filament-accounts::messages.profile.token.helper_text')),
            ])
            ->modalHeading(trans('filament-accounts::messages.profile.token.modal_heading_2'))
            ->modalIcon('heroicon-o-key')
            ->modalAlignment(Alignment::Center)
            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->closeModalByClickingAway(false);
    }

    public function render(): View
    {
        return view('filament-accounts::livewire.sanctum-tokens');
    }
}
