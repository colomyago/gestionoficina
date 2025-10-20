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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function activeLoan()
    {
        return $this->hasOne(Loan::class)->where('status', 'activo')->latest();
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function pendingMaintenanceRequest()
    {
        return $this->hasOne(MaintenanceRequest::class)
            ->whereIn('status', ['pendiente', 'en_proceso'])
            ->latest();
    }

    public function isAvailable()
    {
        return $this->status === 'disponible';
    }

    public function isLoaned()
    {
        return $this->status === 'prestado';
    }

    public function isInMaintenance()
    {
        return $this->status === 'mantenimiento';
    }

    public function isDecommissioned()
    {
        return $this->status === 'baja';
    }
}
