<?php

namespace App\Services;

use Carbon\Carbon;

class DateValidationService
{
    /**
     * Validar que una fecha de devolución sea válida
     * 
     * @param string|null $date Fecha a validar
     * @param int $minDays Días mínimos hacia el futuro (default: 1)
     * @param int|null $maxDays Días máximos hacia el futuro (null = sin límite)
     * @return array ['valid' => bool, 'message' => string]
     */
    public static function validateReturnDate(?string $date, int $minDays = 1, ?int $maxDays = null): array
    {
        // Validar que la fecha exista
        if (!$date) {
            return [
                'valid' => false,
                'message' => __('The return date is required.')
            ];
        }

        try {
            $returnDate = Carbon::parse($date)->startOfDay();
            $today = Carbon::today();
            
            // Validar que no sea en el pasado
            if ($returnDate->lt($today)) {
                return [
                    'valid' => false,
                    'message' => __('The return date cannot be in the past.')
                ];
            }

            // Validar días mínimos
            if ($returnDate->diffInDays($today) < $minDays) {
                return [
                    'valid' => false,
                    'message' => __('The return date must be at least :days day(s) from today.', ['days' => $minDays])
                ];
            }

            // Validar días máximos (si aplica)
            if ($maxDays !== null && $returnDate->diffInDays($today) > $maxDays) {
                return [
                    'valid' => false,
                    'message' => __('The return date cannot exceed :days day(s) from today.', ['days' => $maxDays])
                ];
            }

            return [
                'valid' => true,
                'message' => __('Valid date.')
            ];

        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => __('Invalid date format.')
            ];
        }
    }

    /**
     * Validar que una fecha no sea futura
     * 
     * @param string|null $date Fecha a validar
     * @return array ['valid' => bool, 'message' => string]
     */
    public static function validatePastOrPresentDate(?string $date): array
    {
        if (!$date) {
            return [
                'valid' => false,
                'message' => __('The date is required.')
            ];
        }

        try {
            $checkDate = Carbon::parse($date)->startOfDay();
            $today = Carbon::today();
            
            if ($checkDate->gt($today)) {
                return [
                    'valid' => false,
                    'message' => __('The date cannot be in the future.')
                ];
            }

            return [
                'valid' => true,
                'message' => __('Valid date.')
            ];

        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => __('Invalid date format.')
            ];
        }
    }

    /**
     * Calcular fecha de devolución basada en período de días
     * 
     * @param int $days Número de días a agregar
     * @return string Fecha en formato Y-m-d
     */
    public static function calculateReturnDate(int $days): string
    {
        return Carbon::now()->addDays($days)->format('Y-m-d');
    }

    /**
     * Verificar si una fecha está vencida
     * 
     * @param string|null $date Fecha a verificar
     * @return bool True si está vencida, False en caso contrario
     */
    public static function isOverdue(?string $date): bool
    {
        if (!$date) {
            return false;
        }

        try {
            $dueDate = Carbon::parse($date)->endOfDay();
            return $dueDate->isPast();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Obtener días restantes hasta una fecha
     * 
     * @param string|null $date Fecha objetivo
     * @return int|null Días restantes (negativo si está vencida)
     */
    public static function daysUntil(?string $date): ?int
    {
        if (!$date) {
            return null;
        }

        try {
            $targetDate = Carbon::parse($date)->startOfDay();
            $today = Carbon::today();
            
            return $today->diffInDays($targetDate, false);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Formatear fecha para mostrar
     * 
     * @param string|null $date Fecha a formatear
     * @param string $format Formato de salida (default: d/m/Y)
     * @return string|null Fecha formateada o null
     */
    public static function format(?string $date, string $format = 'd/m/Y'): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            return Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}
