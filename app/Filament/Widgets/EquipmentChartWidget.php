<?php

namespace App\Filament\Widgets;

use App\Models\Equipment;
use Filament\Widgets\ChartWidget;

class EquipmentChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    public function getHeading(): string
    {
        return 'Equipos por Estado';
    }

    protected function getData(): array
    {
        $disponible = Equipment::where('status', 'disponible')->count();
        $prestado = Equipment::where('status', 'prestado')->count();
        $mantenimiento = Equipment::where('status', 'mantenimiento')->count();
        $baja = Equipment::where('status', 'baja')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Equipos',
                    'data' => [$disponible, $prestado, $mantenimiento, $baja],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)',
                        'rgb(251, 191, 36)',
                        'rgb(59, 130, 246)',
                        'rgb(239, 68, 68)',
                    ],
                ],
            ],
            'labels' => ['Disponible', 'Prestado', 'Mantenimiento', 'Baja'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public static function canView(): bool
    {
        return auth()->user()->isAdmin();
    }
}
