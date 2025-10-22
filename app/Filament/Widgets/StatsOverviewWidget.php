<?php

namespace App\Filament\Widgets;

use App\Models\Equipment;
use App\Models\Loan;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->getAdminStats();
        }

        if ($user->isTrabajador()) {
            return $this->getTrabajadorStats();
        }

        if ($user->isMantenimiento()) {
            return $this->getMantenimientoStats();
        }

        return [];
    }

    protected function getAdminStats(): array
    {
        return [
            Stat::make('Total Equipos', Equipment::count())
                ->description('Equipos en el sistema')
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('success'),

            Stat::make('Equipos Disponibles', Equipment::where('status', 'disponible')->count())
                ->description('Listos para préstamo')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Equipos Prestados', Equipment::where('status', 'prestado')->count())
                ->description('Actualmente en uso')
                ->descriptionIcon('heroicon-o-arrow-path')
                ->color('warning'),

            Stat::make('Solicitudes Pendientes', Loan::where('status', 'pendiente')->count())
                ->description('Esperando aprobación')
                ->descriptionIcon('heroicon-o-clock')
                ->color('danger'),

            Stat::make('En Mantenimiento', Equipment::where('status', 'mantenimiento')->count())
                ->description('Equipos siendo reparados')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color('info'),

            Stat::make('Total Usuarios', User::count())
                ->description('Usuarios registrados')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
        ];
    }

    protected function getTrabajadorStats(): array
    {
        $userId = auth()->id();

        return [
            Stat::make('Mis Préstamos Activos', Loan::where('user_id', $userId)->where('status', 'activo')->count())
                ->description('Equipos que tengo')
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('success'),

            Stat::make('Solicitudes Pendientes', Loan::where('user_id', $userId)->where('status', 'pendiente')->count())
                ->description('Esperando aprobación')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Equipos Disponibles', Equipment::where('status', 'disponible')->count())
                ->description('Para solicitar')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('info'),
        ];
    }

    protected function getMantenimientoStats(): array
    {
        $userId = auth()->id();

        return [
            Stat::make('Solicitudes Pendientes', MaintenanceRequest::where('status', 'pendiente')->count())
                ->description('Sin asignar')
                ->descriptionIcon('heroicon-o-inbox')
                ->color('danger'),

            Stat::make('Mis Tareas', MaintenanceRequest::where('assigned_to', $userId)->whereIn('status', ['pendiente', 'en_proceso'])->count())
                ->description('Asignadas a mí')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color('warning'),

            Stat::make('Equipos en Mantenimiento', Equipment::where('status', 'mantenimiento')->count())
                ->description('Total en reparación')
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('info'),
        ];
    }
}
