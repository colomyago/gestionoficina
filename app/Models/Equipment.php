<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'codigo',
        'categoria',
        'description',
        'status',
        'user_id',
        'fecha_prestado',
        'fecha_devolucion'
    ];

    protected $casts = [
        'fecha_prestado' => 'date',
        'fecha_devolucion' => 'date',
    ];

    // Usuario que actualmente tiene el equipo
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Historial de préstamos
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // Préstamo actual activo
    public function activeLoan()
    {
        return $this->hasOne(Loan::class)->where('status', 'activo')->latest();
    }

    // Solicitudes de mantenimiento
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // Solicitud de mantenimiento pendiente
    public function pendingMaintenanceRequest()
    {
        return $this->hasOne(MaintenanceRequest::class)
            ->whereIn('status', ['pendiente', 'en_proceso'])
            ->latest();
    }

    // Verificar si está disponible para préstamo
    public function isAvailable()
    {
        return $this->status === 'disponible';
    }

    // Verificar si está prestado
    public function isLoaned()
    {
        return $this->status === 'prestado';
    }

    // Verificar si está en mantenimiento
    public function isInMaintenance()
    {
        return $this->status === 'mantenimiento';
    }

    // Verificar si está dado de baja
    public function isDecommissioned()
    {
        return $this->status === 'baja';
    }
}
