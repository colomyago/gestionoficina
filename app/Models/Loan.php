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
        'fecha_devolucion_real',
        'motivo',
        'notas'
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_prestamo' => 'datetime',
        'fecha_devolucion' => 'date',
        'fecha_devolucion_real' => 'date',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function isPending()
    {
        return $this->status === 'pendiente';
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

    public function scopePending($query)
    {
        return $query->where('status', 'pendiente');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'activo');
    }
}
