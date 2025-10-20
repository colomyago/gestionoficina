<?php

namespace App\Filament\Resources\Loan;

use App\Models\Loan;
use Filament\Resources\Resource;

// ARCHIVO TEMPORAL DESHABILITADO
// Este archivo fue creado automáticamente pero causa errores de compatibilidad
// Para crear el recurso correctamente según tu versión de Filament, usa:
// php artisan make:filament-resource Loan --generate

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    // Ocultar de la navegación para evitar errores
    protected static bool $shouldRegisterNavigation = false;
}

