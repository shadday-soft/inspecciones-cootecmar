<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\RolePermissionAudit;
use App\Models\User;
use App\Policies\ProjectPolicy;
use App\Policies\RolePermissionAuditPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Project::class => ProjectPolicy::class,
        RolePermissionAudit::class => RolePermissionAuditPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gates personalizados para funcionalidades específicas
        Gate::define('manage-system', function (User $user) {
            return $user->hasPermissionTo('configurar sistema');
        });

        Gate::define('access-dashboard', function (User $user) {
            return $user->hasPermissionTo('acceso dashboard');
        });

        Gate::define('assign-inspections', function (User $user) {
            return $user->hasPermissionTo('asignar inspecciones');
        });

        Gate::define('export-reports', function (User $user) {
            return $user->hasPermissionTo('exportar reportes');
        });

        Gate::define('manage-user-roles', function (User $user, User $targetUser) {
            return $user->hasPermissionTo('gestionar roles usuarios') && $user->id !== $targetUser->id;
        });

        Gate::define('view-own-profile', function (User $user, User $targetUser) {
            return $user->id === $targetUser->id;
        });

        // Gate para super admin que puede hacer todo
        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('Administrador')) {
                return true;
            }
        });
    }
}
