<?php

namespace TomatoPHP\FilamentAccounts\Filament\Pages;

use Filament\Actions\CreateAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class AccountRequest extends Page implements HasTable, HasForms
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static string $view = 'filament-accounts::pages.edit-requests';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return  trans('filament-accounts::messages.account-requests.title');
    }

    public static function getNavigationLabel(): string
    {
        return  trans('filament-accounts::messages.account-requests.title');
    }

    public function table(Table $table): Table
    {
        $columns = [];

        if(filament('filament-saas-accounts')->useTypes){
            $columns[] =TypeColumn::make('type')
                ->label(trans('filament-accounts::messages.requests.columns.type'))
                ->searchable();
            $columns[] = TypeColumn::make('status')
                ->label(trans('filament-accounts::messages.requests.columns.status'))
                ->searchable();
        }
        else {
            $columns[] =Tables\Columns\TextColumn::make('type')
                ->label(trans('filament-accounts::messages.requests.columns.type'))
                ->searchable();
            $columns[] = Tables\Columns\TextColumn::make('status')
                ->label(trans('filament-accounts::messages.requests.columns.status'))
                ->searchable();
        }


        $columns = array_merge($columns, [
            Tables\Columns\IconColumn::make('is_approved')
                ->label(trans('filament-accounts::messages.requests.columns.is_approved'))
                ->boolean(),
            Tables\Columns\TextColumn::make('is_approved_at')
                ->label(trans('filament-accounts::messages.requests.columns.is_approved_at'))
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ]);

        return $table
            ->query(\TomatoPHP\FilamentAccounts\Models\AccountRequest::query()->where('account_id', auth('accounts')->user()->id))
            ->headerActions([
                Tables\Actions\Action::make('create')
                    ->form($this->getRequestForm())
                    ->action(function(array $data){
                        $type = auth('accounts')->user()->requests()->create([
                           'type' => $data['type']
                        ]);


                        foreach ($data as $key=>$item){
                            if($key !== 'type'){
                                $type->meta($key, $item);
                            }
                        }
                    })

            ])
            ->columns($columns)
            ->filters([

            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->icon('heroicon-s-pencil-square')
                    ->fillForm(function ($record){
                        $metaItems = $record->accountRequestMetas->pluck('value', 'key')->toArray();
                        return array_merge([
                            "type" => $record->type
                        ], $metaItems);
                    })
                    ->form(fn($record) => $this->getRequestForm($record))
                    ->action(function(array $data, $record){
                        $record->update($data);

                        foreach ($data as $key=>$item){
                            if($key !== 'type'){
                                $record->meta($key, $item);
                            }
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getRequestForm($record=null): array
    {
        $form = [
            Forms\Components\Select::make('type')
                ->disabled(fn($record) => $record)
                ->label(trans('filament-accounts::messages.requests.columns.type'))
                ->options(Type::query()->where('for', 'account-requests')->where('type', 'types')->pluck('name', 'key')->toArray())
                ->searchable()
                ->required()
                ->live()
                ->preload(),
        ];

        foreach (filament('filament-saas-accounts')->requestsForm as $formItems){
            foreach ($formItems->schema as $item){
                $item->hidden(fn(Forms\Get $get) => $get('type') !== $formItems->type);
                if($record){
                    $approved = $record->accountRequestMetas()->where('key', $item->getName())->first()?->is_approved;
                    $rejected = $record->accountRequestMetas()->where('key', $item->getName())->first();

                    $item->disabled($approved ? true : false);
                    $item->hint( $approved ? 'Approved' : ($rejected ? $rejected->rejected_reason :'Under Review'));
                    $item->hintColor($approved ? 'success' : ($rejected ? 'danger' :'warning'));
                    $item->hintIcon($approved ? 'heroicon-s-check-circle' : ($rejected ? 'heroicon-s-x-circle' :'heroicon-s-clock'));
                }
                $form[] = $item;
            }
        };

        return $form;
    }
}
