<?php

namespace App\Filament\Resources\Equipment\Tables;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EquipmentTable
/*************  ✨ Windsurf Command ⭐  *************/
        /**
         * Configure the table's columns, filters, and actions.
         *
         * @param  Table  $table
         * @return Table
         */
        
/*******  278ea683-6654-46db-bee6-720f6bb89a93  *******/{

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->translateLabel()
                    ->label('Usuario')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fecha_prestado')
                    ->translateLabel()
                    ->date()
                    ->sortable(),
                TextColumn::make('fecha_devolucion')
                    ->translateLabel()
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ])
               
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}