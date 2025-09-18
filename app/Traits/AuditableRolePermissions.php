<?php

namespace App\Traits;

use App\Models\RolePermissionAudit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait AuditableRolePermissions
{
    /**
     * Log an audit event for role/permission changes
     */
    public static function logAudit(
        string $action,
        $auditable,
        string $event,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null,
        ?int $targetUserId = null
    ): void {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        RolePermissionAudit::create([
            'action' => $action,
            'auditable_type' => get_class($auditable),
            'auditable_id' => $auditable->id,
            'event' => $event,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
            'user_id' => $user->id,
            'target_user_id' => $targetUserId,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log role creation
     */
    public static function logRoleCreated($role): void
    {
        self::logAudit(
            'created',
            $role,
            'role_created',
            null,
            $role->toArray(),
            "Rol '{$role->name}' creado"
        );
    }

    /**
     * Log role update
     */
    public static function logRoleUpdated($role, array $originalData): void
    {
        self::logAudit(
            'updated',
            $role,
            'role_updated',
            $originalData,
            $role->toArray(),
            "Rol '{$role->name}' actualizado"
        );
    }

    /**
     * Log role deletion
     */
    public static function logRoleDeleted($role): void
    {
        self::logAudit(
            'deleted',
            $role,
            'role_deleted',
            $role->toArray(),
            null,
            "Rol '{$role->name}' eliminado"
        );
    }

    /**
     * Log permission creation
     */
    public static function logPermissionCreated($permission): void
    {
        self::logAudit(
            'created',
            $permission,
            'permission_created',
            null,
            $permission->toArray(),
            "Permiso '{$permission->name}' creado"
        );
    }

    /**
     * Log permission update
     */
    public static function logPermissionUpdated($permission, array $originalData): void
    {
        self::logAudit(
            'updated',
            $permission,
            'permission_updated',
            $originalData,
            $permission->toArray(),
            "Permiso '{$permission->name}' actualizado"
        );
    }

    /**
     * Log permission deletion
     */
    public static function logPermissionDeleted($permission): void
    {
        self::logAudit(
            'deleted',
            $permission,
            'permission_deleted',
            $permission->toArray(),
            null,
            "Permiso '{$permission->name}' eliminado"
        );
    }

    /**
     * Log role assignment to user
     */
    public static function logRoleAssignedToUser($user, $role): void
    {
        self::logAudit(
            'assigned',
            $role,
            'role_assigned_to_user',
            null,
            ['user_id' => $user->id, 'role_id' => $role->id],
            "Rol '{$role->name}' asignado a usuario '{$user->name}'",
            $user->id
        );
    }

    /**
     * Log role removal from user
     */
    public static function logRoleRemovedFromUser($user, $role): void
    {
        self::logAudit(
            'removed',
            $role,
            'role_removed_from_user',
            ['user_id' => $user->id, 'role_id' => $role->id],
            null,
            "Rol '{$role->name}' removido de usuario '{$user->name}'",
            $user->id
        );
    }

    /**
     * Log permission assignment to role
     */
    public static function logPermissionAssignedToRole($role, $permission): void
    {
        self::logAudit(
            'assigned',
            $permission,
            'permission_assigned_to_role',
            null,
            ['role_id' => $role->id, 'permission_id' => $permission->id],
            "Permiso '{$permission->name}' asignado a rol '{$role->name}'"
        );
    }

    /**
     * Log permission removal from role
     */
    public static function logPermissionRemovedFromRole($role, $permission): void
    {
        self::logAudit(
            'removed',
            $permission,
            'permission_removed_from_role',
            ['role_id' => $role->id, 'permission_id' => $permission->id],
            null,
            "Permiso '{$permission->name}' removido de rol '{$role->name}'"
        );
    }
}
