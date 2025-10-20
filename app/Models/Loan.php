<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'assigned_by',
        'status',
        'fecha_solicitud',
        'fecha_prestamo',
        'fecha_devolucion',
        'motivo',
        'notas'
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_prestamo' => 'date',
        'fecha_devolucion' => 'date',
    ];

    // Relación con el equipo
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    // Relación con el usuario que tiene el equipo
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el admin que asignó el equipo
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // Métodos helper
    public function isPending()
    {
        return $this->status === 'pendiente';
    }

    public function isApproved()
    {
        return $this->status === 'aprobado';
    }

    public function isActive()
    {
        return $this->status === 'activo';
    }

    public function isReturned()
    {
        return $this->status === 'devuelto';
    }

    public function isRejected()
    {
        return $this->status === 'rechazado';
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pendiente');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'activo');
    }
}
