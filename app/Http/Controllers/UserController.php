<?php

namespace App\Http\Controllers;

use App\Models\RolePermissionAudit;
use App\Models\User;
use App\Traits\AuditableRolePermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use AuditableRolePermissions;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        if (request()->wantsJson()) {
            return response()->json($users);
        }

        return Inertia::render('Users/index', [
            'users' => $users,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function settings(Request $request)
    {
        $user = auth()->user();
        $activeTab = $request->get('tab', 'signature');

        // Datos base para todas las pestañas
        $data = [
            'user' => $user,
            'activeTab' => $activeTab,
        ];

        // Datos para pestaña de usuarios
        $data['users'] = User::with('roles')->get();

        // Datos para pestaña de roles
        $rolesQuery = Role::with('permissions')->orderBy('name');

        // Aplicar filtros de roles si están presentes
        if ($request->filled('search') && $activeTab === 'roles') {
            $rolesQuery->where('name', 'like', "%{$request->search}%");
        }
        if ($request->filled('guard') && $activeTab === 'roles') {
            $rolesQuery->where('guard_name', $request->guard);
        }
        if ($request->filled('has_permissions') && $activeTab === 'roles') {
            if ($request->has_permissions === 'yes') {
                $rolesQuery->has('permissions');
            } elseif ($request->has_permissions === 'no') {
                $rolesQuery->doesntHave('permissions');
            }
        }

        $data['roles'] = $rolesQuery->paginate(10);
        $data['rolesFilters'] = $request->only(['search', 'guard', 'has_permissions']);

        // Datos para pestaña de permisos
        $permissionsQuery = Permission::with('roles')->orderBy('name');

        // Aplicar filtros de permisos si están presentes
        if ($request->filled('search') && $activeTab === 'permissions') {
            $permissionsQuery->where('name', 'like', "%{$request->search}%");
        }
        if ($request->filled('guard') && $activeTab === 'permissions') {
            $permissionsQuery->where('guard_name', $request->guard);
        }
        if ($request->filled('has_roles') && $activeTab === 'permissions') {
            if ($request->has_roles === 'yes') {
                $permissionsQuery->has('roles');
            } elseif ($request->has_roles === 'no') {
                $permissionsQuery->doesntHave('roles');
            }
        }

        $data['permissions'] = $permissionsQuery->paginate(15);
        $data['permissionsFilters'] = $request->only(['search', 'guard', 'has_roles']);

        // Datos para pestaña de auditoría
        $auditsQuery = RolePermissionAudit::with('user')
            ->orderBy('created_at', 'desc');

        // Aplicar filtros de auditoría si están presentes
        if ($request->filled('search') && $activeTab === 'audit') {
            $search = $request->get('search');
            $auditsQuery->where(function ($q) use ($search) {
                $q->where('auditable_type', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('event', 'like', "%{$search}%");
            });
        }
        if ($request->filled('action') && $activeTab === 'audit') {
            $auditsQuery->where('action', $request->get('action'));
        }
        if ($request->filled('entity_type') && $activeTab === 'audit') {
            $auditsQuery->where('auditable_type', $request->get('entity_type'));
        }
        if ($request->filled('user_id') && $activeTab === 'audit') {
            $auditsQuery->where('user_id', $request->get('user_id'));
        }
        if ($request->filled('date_from') && $activeTab === 'audit') {
            $auditsQuery->whereDate('created_at', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to') && $activeTab === 'audit') {
            $auditsQuery->whereDate('created_at', '<=', $request->get('date_to'));
        }

        $data['audits'] = $auditsQuery->paginate(15);
        $data['auditsFilters'] = $request->only(['search', 'action', 'entity_type', 'user_id', 'date_from', 'date_to']);

        // Datos compartidos para filtros
        $data['guards'] = Role::distinct()->pluck('guard_name');
        $data['actions'] = RolePermissionAudit::distinct()->pluck('action')->filter()->values();
        $data['entityTypes'] = RolePermissionAudit::distinct()->pluck('auditable_type')->filter()->values();
        $data['auditUsers'] = User::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Users/settings', $data);
    }

    public function signature(Request $request)
    {
        $signature = $request->signature;
        if (is_string($signature)) {
            // Imagen base64 a imagen .png
            $exploded = explode(',', $signature);
            $decoded = base64_decode($exploded[1]);
            $filename = 'signature-'.time().'.'.'png';
            // Almacenar imagen en storage
            file_put_contents('storage/signatures/'.$filename, $decoded);

            $this->saveSignature('signatures/'.$filename);
        } else {
            $request->validate([
                'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $path = $request->file('signature')->store('signatures', 'public');
            $this->saveSignature($path);
        }

        return back()
            ->with('success', 'You have successfully upload image.');
    }

    public function saveSignature($path)
    {
        $user = User::find(auth()->user()->id);
        if ($user->signature) {
            Storage::disk('public')->delete($user->signature);
        }
        $user->signature = $path;
        $user->save();

    }

    /**
     * Asignar roles a un usuario
     */
    public function assignRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $roles = Role::whereIn('id', $request->roles)->get();
        $user->syncRoles($roles);

        return back()->with('success', 'Roles asignados exitosamente al usuario.');
    }

    /**
     * Mostrar página de gestión de roles para un usuario
     */
    public function manageRoles(User $user)
    {
        $user->load('roles');
        $roles = Role::all();

        return Inertia::render('Users/ManageRoles', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }
}
