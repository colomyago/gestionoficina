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
        $lang = app()->getLocale();

        return [
            Stat::make(
                $lang === 'es' ? 'Total de Equipos' : 'Total Equipment',
                Equipment::count()
            )
                ->description($lang === 'es' ? 'Equipos en el sistema' : 'Equipment in the system')
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('success'),

            Stat::make(
                $lang === 'es' ? 'Equipos Disponibles' : 'Available Equipment',
                Equipment::where('status', 'disponible')->count()
            )
                ->description($lang === 'es' ? 'Listos para préstamo' : 'Ready for loan')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make(
                $lang === 'es' ? 'Equipos Prestados' : 'Loaned Equipment',
                Equipment::where('status', 'prestado')->count()
            )
                ->description($lang === 'es' ? 'Actualmente en uso' : 'Currently in use')
                ->descriptionIcon('heroicon-o-arrow-path')
                ->color('warning'),

            Stat::make(
                $lang === 'es' ? 'Solicitudes Pendientes' : 'Pending Requests',
                Loan::where('status', 'pendiente')->count()
            )
                ->description($lang === 'es' ? 'Esperando aprobación' : 'Waiting for approval')
                ->descriptionIcon('heroicon-o-clock')
                ->color('danger'),

            Stat::make(
                $lang === 'es' ? 'En Mantenimiento' : 'In Maintenance',
                Equipment::where('status', 'mantenimiento')->count()
            )
                ->description($lang === 'es' ? 'Equipos siendo reparados' : 'Equipment under repair')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color('info'),

            Stat::make(
                $lang === 'es' ? 'Total de Usuarios' : 'Total Users',
                User::count()
            )
                ->description($lang === 'es' ? 'Usuarios registrados' : 'Registered users')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
        ];
    }

    protected function getTrabajadorStats(): array
    {
        $lang = app()->getLocale();
        $userId = auth()->id();

        return [
            Stat::make(
                $lang === 'es' ? 'Mis Préstamos Activos' : 'My Active Loans',
                Loan::where('user_id', $userId)->where('status', 'activo')->count()
            )
                ->description($lang === 'es' ? 'Equipos que tengo' : 'Equipment I currently have')
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('success'),

            Stat::make(
                $lang === 'es' ? 'Solicitudes Pendientes' : 'Pending Requests',
                Loan::where('user_id', $userId)->where('status', 'pendiente')->count()
            )
                ->description($lang === 'es' ? 'Esperando aprobación' : 'Waiting for approval')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make(
                $lang === 'es' ? 'Equipos Disponibles' : 'Available Equipment',
                Equipment::where('status', 'disponible')->count()
            )
                ->description($lang === 'es' ? 'Para solicitar' : 'Available to request')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('info'),
        ];
    }

    protected function getMantenimientoStats(): array
    {
        $lang = app()->getLocale();
        $userId = auth()->id();

        return [
            Stat::make(
                $lang === 'es' ? 'Solicitudes Pendientes' : 'Pending Requests',
                MaintenanceRequest::where('status', 'pendiente')->count()
            )
                ->description($lang === 'es' ? 'Sin asignar' : 'Unassigned')
                ->descriptionIcon('heroicon-o-inbox')
                ->color('danger'),

            Stat::make(
                $lang === 'es' ? 'Mis Tareas' : 'My Tasks',
                MaintenanceRequest::where('assigned_to', $userId)
                    ->whereIn('status', ['pendiente', 'en_proceso'])
                    ->count()
            )
                ->description($lang === 'es' ? 'Asignadas a mí' : 'Assigned to me')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color('warning'),

            Stat::make(
                $lang === 'es' ? 'Equipos en Mantenimiento' : 'Equipment in Maintenance',
                Equipment::where('status', 'mantenimiento')->count()
            )
                ->description($lang === 'es' ? 'Total en reparación' : 'Total under repair')
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('info'),
        ];
    }
}