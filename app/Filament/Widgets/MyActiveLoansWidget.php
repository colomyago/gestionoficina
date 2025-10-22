<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MyActiveLoansWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::query()
                    ->with(['equipment'])
                    ->where('user_id', auth()->id())
                    ->where('status', 'activo')
            )
            ->columns([
                Tables\Columns\TextColumn::make('equipment.name')
                    ->label('Equipo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('equipment.codigo')
                    ->label('Código')
                    ->searchable(),

                Tables\Columns\TextColumn::make('fecha_prestamo')
                    ->label('Fecha Préstamo')
                    ->date('d/m/Y'),

                Tables\Columns\TextColumn::make('fecha_devolucion')
                    ->label('Fecha Devolución')
                    ->date('d/m/Y')
                    ->color(fn ($record) => $record->fecha_devolucion < now() ? 'danger' : 'success'),
            ])
            ->heading('Mis Equipos Prestados')
            ->emptyStateHeading('No tienes equipos prestados')
            ->emptyStateDescription('Solicita un equipo desde el panel de Solicitudes')
            ->emptyStateIcon('heroicon-o-inbox');
    }

    public static function canView(): bool
    {
        return auth()->user()->isTrabajador();
    }
}
