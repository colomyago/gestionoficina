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
        
        return [
            'all' => Tab::make(__('All'))
                ->badge(fn () => \App\Models\Loan::where('user_id', $userId)->count()),
            
            'pending' => Tab::make(__('Pending'))
                ->badge(fn () => \App\Models\Loan::where('user_id', $userId)->where('status', 'pendiente')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pendiente')),
            
            'active' => Tab::make(__('Active'))
                ->badge(fn () => \App\Models\Loan::where('user_id', $userId)->where('status', 'activo')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'activo')),
            
            'returned' => Tab::make(__('Returned'))
                ->badge(fn () => \App\Models\Loan::where('user_id', $userId)->where('status', 'devuelto')->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'devuelto')),
            
            'rejected' => Tab::make(__('Rejected'))
                ->badge(fn () => \App\Models\Loan::where('user_id', $userId)->where('status', 'rechazado')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rechazado')),
        ];
    }
}
