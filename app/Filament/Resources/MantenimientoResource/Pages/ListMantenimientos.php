<?php

namespace App\Filament\Resources\MantenimientoResource\Pages;

use App\Filament\Resources\MantenimientoResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMantenimientos extends ListRecords
{
    protected static string $resource = MantenimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function getTabs(): array
    {
        return [
            'pending' => Tab::make(__('Pending'))
                ->badge(fn () => \App\Models\MaintenanceRequest::where('status', 'pendiente')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pendiente')),
            
            'in_progress' => Tab::make(__('In Progress'))
                ->badge(fn () => \App\Models\MaintenanceRequest::where('status', 'en_proceso')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'en_proceso')),
            
            'completed' => Tab::make(__('Completed'))
                ->badge(fn () => \App\Models\MaintenanceRequest::where('status', 'completado')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completado')),
            
            'all' => Tab::make(__('All'))
                ->badge(fn () => \App\Models\MaintenanceRequest::count()),
        ];
    }
}
