<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'event',
        'auditable_type',
        'auditable_id',
        'user_id',
        'old_values',
        'new_values',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el usuario que ejecutó la acción
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación polimórfica con el registro auditado
     */
    public function auditable()
    {
        return $this->morphTo();
    }

    /**
     * Registrar un evento de auditoría
     */
    public static function log(
        string $event,
        Model $auditable,
        ?User $user = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): self {
        $user = $user ?? auth()->user();
        
        return self::create([
            'event' => $event,
            'auditable_type' => get_class($auditable),
            'auditable_id' => $auditable->id,
            'user_id' => $user?->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Scopes para filtrar por evento
     */
    public function scopeEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    public function scopeForModel($query, Model $model)
    {
        return $query->where('auditable_type', get_class($model))
                    ->where('auditable_id', $model->id);
    }

    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Eventos disponibles para auditoría
     */
    public const LOAN_CREATED = 'loan_created';
    public const LOAN_APPROVED = 'loan_approved';
    public const LOAN_REJECTED = 'loan_rejected';
    public const LOAN_RETURNED = 'loan_returned';
    public const EQUIPMENT_ASSIGNED = 'equipment_assigned';
    public const EQUIPMENT_UNASSIGNED = 'equipment_unassigned';
    public const EQUIPMENT_TO_MAINTENANCE = 'equipment_to_maintenance';
    public const EQUIPMENT_DECOMMISSIONED = 'equipment_decommissioned';
    public const MAINTENANCE_CREATED = 'maintenance_created';
    public const MAINTENANCE_ASSIGNED = 'maintenance_assigned';
    public const MAINTENANCE_COMPLETED = 'maintenance_completed';
    public const MAINTENANCE_REJECTED = 'maintenance_rejected';
}
