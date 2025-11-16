<?php

namespace App\Filament\Resources\Equipment\Pages;

use App\Filament\Resources\Equipment\EquipmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListEquipment extends ListRecords
{
    protected static string $resource = EquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make(__('All'))
                ->badge(fn () => \App\Models\Equipment::count()),
            
            'available' => Tab::make(__('Available'))
                ->badge(fn () => \App\Models\Equipment::where('status', 'disponible')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'disponible')),
            
            'loaned' => Tab::make(__('Loaned'))
                ->badge(fn () => \App\Models\Equipment::where('status', 'prestado')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'prestado')),
            
            'maintenance' => Tab::make(__('Maintenance'))
                ->badge(fn () => \App\Models\Equipment::where('status', 'mantenimiento')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'mantenimiento')),
        ];

        // Solo admin ve equipos dados de baja
        if (\Illuminate\Support\Facades\Auth::user()->isAdmin()) {
            $tabs['decommissioned'] = Tab::make(__('Decommissioned'))
                ->badge(fn () => \App\Models\Equipment::where('status', 'baja')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'baja'));
        }

        return $tabs;
    }
}
