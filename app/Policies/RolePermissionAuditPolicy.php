<?php

namespace App\Policies;

use App\Models\RolePermissionAudit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePermissionAuditPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any audit logs.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('audit.view');
    }

    /**
     * Determine whether the user can view the audit log.
     */
    public function view(User $user, RolePermissionAudit $audit)
    {
        return $user->hasPermissionTo('audit.view');
    }

    /**
     * Determine whether the user can create audit logs.
     */
    public function create(User $user)
    {
        // Los logs de auditoría se crean automáticamente
        return false;
    }

    /**
     * Determine whether the user can update the audit log.
     */
    public function update(User $user, RolePermissionAudit $audit)
    {
        // Los logs de auditoría no se pueden modificar
        return false;
    }

    /**
     * Determine whether the user can delete the audit log.
     */
    public function delete(User $user, RolePermissionAudit $audit)
    {
        // Solo super administradores pueden eliminar logs
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the audit log.
     */
    public function restore(User $user, RolePermissionAudit $audit)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the audit log.
     */
    public function forceDelete(User $user, RolePermissionAudit $audit)
    {
        return $user->hasRole('super-admin');
    }
}
