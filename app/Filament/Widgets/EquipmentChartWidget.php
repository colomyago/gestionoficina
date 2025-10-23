<?php

namespace App\Filament\Widgets;

use App\Models\Equipment;
use Filament\Widgets\ChartWidget;

class EquipmentChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    public ?string $filter = 'all';

    public function getHeading(): string
    {
        return 'Equipos por Estado';
    }

    protected function getFilters(): ?array
    {
        return [
            'all' => 'Todas las categorías',
            'Computadoras' => 'Computadoras',
            'Laptops' => 'Laptops',
            'Tablets' => 'Tablets',
            'Monitores' => 'Monitores',
            'Impresoras' => 'Impresoras',
            'Audio' => 'Audio',
            'Redes' => 'Redes',
            'Almacenamiento' => 'Almacenamiento',
            'Periféricos' => 'Periféricos',
            'Proyección' => 'Proyección',
            'Otros' => 'Otros',
        ];
    }

    protected function getData(): array
    {
        $query = Equipment::query();

        // Aplicar filtro de categoría si no es "all"
        if ($this->filter !== 'all') {
            $query->where('categoria', $this->filter);
        }

        $disponible = (clone $query)->where('status', 'disponible')->count();
        $prestado = (clone $query)->where('status', 'prestado')->count();
        $mantenimiento = (clone $query)->where('status', 'mantenimiento')->count();
        $baja = (clone $query)->where('status', 'baja')->count();

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
