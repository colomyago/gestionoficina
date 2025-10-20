<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'requested_by',
        'assigned_to',
        'status',
        'descripcion_problema',
        'solucion',
        'resultado',
        'fecha_solicitud',
        'fecha_completado'
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_completado' => 'datetime',
    ];

    // Relación con el equipo
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    // Relación con el trabajador que solicitó
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    // Relación con el personal de mantenimiento asignado
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
