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
            Stat::make('Equipos en mi poder', $equiposActivos)
                ->description('Equipos actualmente asignados')
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('primary'),

            Stat::make('Por vencer (7 días)', $equiposPorVencer)
                ->description('Equipos a devolver pronto')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Vencidos', $equiposVencidos)
                ->description('Equipos que debiste devolver')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('danger'),

            Stat::make('Total histórico', $totalPrestamos)
                ->description('Préstamos totales realizados')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('success'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->isTrabajador();
    }
}
