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
        'fecha_prestamo',
        'fecha_devolucion',
        'notas'
    ];

    protected $casts = [
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
}
