<?php

namespace App\Filament\Widgets;

use App\Models\MaintenanceRequest;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingMaintenanceWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MaintenanceRequest::query()
                    ->with(['equipment', 'requestedBy'])
                    ->where('status', 'pendiente')
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('equipment.name')
                    ->label('Equipo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('equipment.codigo')
                    ->label('Código')
                    ->searchable(),

                Tables\Columns\TextColumn::make('requestedBy.name')
                    ->label('Solicitado por')
                    ->searchable(),

                Tables\Columns\TextColumn::make('descripcion_problema')
                    ->label('Problema')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('fecha_solicitud')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->heading('Solicitudes de Mantenimiento Pendientes')
            ->emptyStateHeading('No hay solicitudes pendientes')
            ->emptyStateDescription('Todas las solicitudes están asignadas')
            ->emptyStateIcon('heroicon-o-check-circle');
    }

    public static function canView(): bool
    {
        return auth()->user()->isMantenimiento() || auth()->user()->isAdmin();
    }
}
