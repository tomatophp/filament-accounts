<?php

namespace TomatoPHP\FilamentAccounts\Filament\Resources\AccountRequestResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class AccountRequestMetaManager extends RelationManager
{
    protected static string $relationship = 'accountRequestMetas';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return "Payload";
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->disabled()
                    ->label('Key')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value')
                    ->disabled(),
                Forms\Components\Toggle::make('is_approved')
                    ->afterStateUpdated(function (Get $get, Forms\Set $set){
                        if($get('is_approved')) {
                            $set('is_rejected', false);
                            $set('rejected_reason', "");
                        }
                    })
                    ->live(),
                Forms\Components\Toggle::make('is_rejected')
                    ->afterStateUpdated(function (Get $get, Forms\Set $set){
                        if($get('is_rejected')) {
                            $set('is_approved', false);
                        }
                    })
                    ->live(),
                Forms\Components\Textarea::make('rejected_reason')
                    ->required(fn(Get $get) => $get('is_rejected'))
                    ->hidden(fn(Get $get) => !$get('is_rejected'))
                    ->columnSpan(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('key')
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('value'),
                Tables\Columns\ToggleColumn::make('is_approved')
                    ->afterStateUpdated(function ($record){
                        if($record->is_approved) {
                            $record->is_approved_at = Carbon::now();
                            $record->is_rejected_at = null;
                            $record->is_rejected = false;
                            $record->save();
                        }
                        else {
                            $record->is_approved_at = null;
                            $record->save();
                        }

                        $this->getOwnerRecord()->user_id = auth()->user()->id;
                        $this->getOwnerRecord()->save();
                    }),
                Tables\Columns\ToggleColumn::make('is_rejected')
                    ->afterStateUpdated(function ($record){
                        if($record->is_rejected) {
                            $record->is_rejected_at = Carbon::now();
                            $record->is_approved_at = null;
                            $record->is_approved = false;
                            $record->save();
                        }
                        else {
                            $record->is_rejected_at = null;
                            $record->rejected_reason = null;
                            $record->save();
                        }

                        $this->getOwnerRecord()->user_id = auth()->user()->id;
                        $this->getOwnerRecord()->save();
                    }),
                Tables\Columns\TextColumn::make('is_approved_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_rejected_at')
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

            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function ($record, $data) {
                        if($data['is_rejected'] && !empty($data['rejected_reason'])) {
                            $data['is_rejected_at'] = now();
                            $data['is_approved_at'] = null;
                            $data['is_approved'] = false;
                            $data['user_id'] =  auth()->user()->id;
                        }
                        if($data['is_approved']) {
                            $data['is_rejected_at'] = null;
                            $data['is_rejected'] = false;
                            $data['is_approved_at'] = now();
                            $data['rejected_reason'] = null;
                            $data['user_id'] =  auth()->user()->id;
                        }

                        $this->getOwnerRecord()->user_id = auth()->user()->id;
                        $this->getOwnerRecord()->save();

                        $record->update($data);
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
