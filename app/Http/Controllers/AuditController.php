<?php

namespace App\Http\Controllers;

use App\Models\RolePermissionAudit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditController extends Controller
{
    /**
     * Display a listing of audit logs
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', RolePermissionAudit::class);

        $query = RolePermissionAudit::with('user')
            ->orderBy('created_at', 'desc');

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('auditable_type', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('event', 'like', "%{$search}%");
            });
        }

        if ($request->filled('action')) {
            $query->where('action', $request->get('action'));
        }

        if ($request->filled('entity_type')) {
            $query->where('auditable_type', $request->get('entity_type'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        $audits = $query->paginate(15)->withQueryString();

        // Obtener opciones para filtros
        $actions = RolePermissionAudit::distinct()->pluck('action')->filter()->values();
        $entityTypes = RolePermissionAudit::distinct()->pluck('auditable_type')->filter()->values();
        $users = \App\Models\User::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Audit/Index', [
            'audits' => $audits,
            'filters' => $request->only(['search', 'action', 'entity_type', 'user_id', 'date_from', 'date_to']),
            'actions' => $actions,
            'entityTypes' => $entityTypes,
            'users' => $users,
        ]);
    }

    /**
     * Show specific audit details
     */
    public function show(RolePermissionAudit $audit)
    {
        $this->authorize('view', $audit);

        $audit->load('user');

        return Inertia::render('Audit/Show', [
            'audit' => $audit,
        ]);
    }

    /**
     * Get audit statistics
     */
    public function stats()
    {
        $this->authorize('viewAny', RolePermissionAudit::class);

        $stats = [
            'total_audits' => RolePermissionAudit::count(),
            'audits_today' => RolePermissionAudit::whereDate('created_at', today())->count(),
            'audits_this_week' => RolePermissionAudit::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'audits_this_month' => RolePermissionAudit::whereMonth('created_at', now()->month)->count(),
            'actions_breakdown' => RolePermissionAudit::selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->get()
                ->pluck('count', 'action'),
            'types_breakdown' => RolePermissionAudit::selectRaw('auditable_type, COUNT(*) as count')
                ->groupBy('auditable_type')
                ->get()
                ->pluck('count', 'auditable_type'),
        ];

        return response()->json($stats);
    }
}
