<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RolePermissionAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'auditable_type',
        'auditable_id',
        'event',
        'old_values',
        'new_values',
        'description',
        'user_id',
        'target_user_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Get the auditable model (Role, Permission, User)
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the target user (for role assignments)
     */
    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    /**
     * Scope para filtrar por tipo de auditable
     */
    public function scopeForType($query, string $type)
    {
        return $query->where('auditable_type', $type);
    }

    /**
     * Scope para filtrar por usuario
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para filtrar por acción
     */
    public function scopeForAction($query, string $action)
    {
        return $query->where('action', $action);
    }
}
