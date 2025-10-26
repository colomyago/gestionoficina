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
                    ->label(__('Device'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('equipment.codigo')
                    ->label(__('Code'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('requestedBy.name')
                    ->label(__('Requested by'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('descripcion_problema')
                    ->label(__('Problem'))
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('fecha_solicitud')
                    ->label(__('Date'))
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->heading(__('Pending Maintenance Requests'))
            ->emptyStateHeading(__('No pending requests'))
            ->emptyStateDescription(__('All requests are assigned'))
            ->emptyStateIcon('heroicon-o-check-circle');
    }

    public static function canView(): bool
    {
        return auth()->user()->isMantenimiento() || auth()->user()->isAdmin();
    }
}