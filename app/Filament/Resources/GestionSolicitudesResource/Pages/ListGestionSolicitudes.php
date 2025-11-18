<?php

namespace App\Filament\Resources\GestionSolicitudesResource\Pages;

use App\Filament\Resources\GestionSolicitudesResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListGestionSolicitudes extends ListRecords
{
    protected static string $resource = GestionSolicitudesResource::class;

    public ?string $activeTab = 'pending';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('All'))
                ->badge(fn () => \App\Models\Loan::count()),
            
            'pending' => Tab::make(__('Pending'))
                ->badge(fn () => \App\Models\Loan::where('status', 'pendiente')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pendiente')),
            
            'active' => Tab::make(__('Active'))
                ->badge(fn () => \App\Models\Loan::where('status', 'activo')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'activo')),
            
            'returned' => Tab::make(__('Returned'))
                ->badge(fn () => \App\Models\Loan::where('status', 'devuelto')->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'devuelto')),
            
            'rejected' => Tab::make(__('Rejected'))
                ->badge(fn () => \App\Models\Loan::where('status', 'rechazado')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rechazado')),
        ];
    }
}
