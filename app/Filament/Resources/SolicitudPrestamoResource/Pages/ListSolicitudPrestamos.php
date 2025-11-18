<?php

namespace App\Filament\Resources\SolicitudPrestamoResource\Pages;

use App\Filament\Resources\SolicitudPrestamoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListSolicitudPrestamos extends ListRecords
{
    protected static string $resource = SolicitudPrestamoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('New request'))
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        $userId = Auth::id();
        $isAdmin = Auth::user()->isAdmin();
        
        $baseQuery = function (Builder $query) use ($userId, $isAdmin) {
            return $isAdmin ? $query : $query->where('user_id', $userId);
        };
        
        return [
            'all' => Tab::make(__('All'))
                ->badge(fn () => \App\Models\Loan::tap($baseQuery)->count())
                ->modifyQueryUsing($baseQuery),
            
            'pending' => Tab::make(__('Pending'))
                ->badge(fn () => \App\Models\Loan::tap($baseQuery)->where('status', 'pendiente')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $baseQuery($query)->where('status', 'pendiente')),
            
            'active' => Tab::make(__('Active'))
                ->badge(fn () => \App\Models\Loan::tap($baseQuery)->where('status', 'activo')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $baseQuery($query)->where('status', 'activo')),
            
            'returned' => Tab::make(__('Returned'))
                ->badge(fn () => \App\Models\Loan::tap($baseQuery)->where('status', 'devuelto')->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $baseQuery($query)->where('status', 'devuelto')),
            
            'rejected' => Tab::make(__('Rejected'))
                ->badge(fn () => \App\Models\Loan::tap($baseQuery)->where('status', 'rechazado')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $baseQuery($query)->where('status', 'rechazado')),
        ];
    }
}
