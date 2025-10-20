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

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
