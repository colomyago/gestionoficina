<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MisEquiposStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();
        
        // Equipos activos
        $equiposActivos = Loan::where('user_id', $userId)
            ->where('status', 'activo')
            ->count();

        // Equipos por vencer (próximos 7 días)
        $equiposPorVencer = Loan::where('user_id', $userId)
            ->where('status', 'activo')
            ->whereBetween('fecha_devolucion', [now(), now()->addDays(7)])
            ->count();

        // Equipos vencidos
        $equiposVencidos = Loan::where('user_id', $userId)
            ->where('status', 'activo')
            ->where('fecha_devolucion', '<', now())
            ->count();

        // Total de préstamos históricos
        $totalPrestamos = Loan::where('user_id', $userId)
            ->count();

        return [
            Stat::make(__('Devices in my possession'), $equiposActivos)
                ->description(__('Currently assigned devices'))
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('primary'),

            Stat::make(__('Due soon (7 days)'), $equiposPorVencer)
                ->description(__('Devices to return soon'))
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make(__('Overdue'), $equiposVencidos)
                ->description(__('Devices you should have returned'))
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('danger'),

            Stat::make(__('Total history'), $totalPrestamos)
                ->description(__('Total loans made'))
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('success'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->isTrabajador();
    }
}