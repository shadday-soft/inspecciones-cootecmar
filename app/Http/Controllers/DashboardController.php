<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal con estadísticas y calendario de inspecciones
     */
    public function index(): \Inertia\Response
    {
        // KPIs Principales
        $totalInspections = Inspection::count();
        
        $completedInspections30Days = Inspection::where('fecha', '>=', Carbon::now()->subDays(30))
            ->whereNotNull('fecha_programada')
            ->count();
        
        $activeInspectors = User::whereHas('inspections')
            ->distinct()
            ->count();
        
        $upcomingInspections7Days = Inspection::whereBetween('fecha_programada', [
            Carbon::now(),
            Carbon::now()->addDays(7)
        ])->count();

        // Datos para Gráficas
        
        // 1. Inspecciones por Tipo
        $inspectionsByType = Inspection::select(
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(tipo, "$[0]")) as tipo_principal'),
            DB::raw('COUNT(*) as total')
        )
        ->whereNotNull('tipo')
        ->groupBy('tipo_principal')
        ->get()
        ->mapWithKeys(function ($item) {
            return [$item->tipo_principal ?: 'Sin especificar' => $item->total];
        });

        // 2. Estado General de Inspecciones (simulado con fechas)
        $today = Carbon::now();
        $inspectionsByStatus = [
            'Programada' => Inspection::where('fecha_programada', '>', $today)->count(),
            'En Progreso' => Inspection::whereDate('fecha_programada', $today)->count(),
            'Completada' => Inspection::where('fecha_programada', '<', $today)
                ->whereNotNull('fecha_programada')
                ->count(),
            'Pendiente' => Inspection::whereNull('fecha_programada')->count(),
        ];

        // 3. Rendimiento de Inspectores (último trimestre)
        $lastQuarter = Carbon::now()->subMonths(3);
        $inspectorPerformance = Inspection::with('user')
            ->where('created_at', '>=', $lastQuarter)
            ->whereNotNull('user_id')
            ->select('user_id', DB::raw('COUNT(*) as total'))
            ->groupBy('user_id')
            ->get()
            ->filter(function ($item) {
                return $item->user !== null; // Filtrar usuarios nulos
            })
            ->mapWithKeys(function ($item) {
                return [
                    $item->user->name ?? 'Sin asignar' => $item->total
                ];
            });

        // Si no hay datos de inspectores, agregar datos de ejemplo
        if ($inspectorPerformance->isEmpty()) {
            $inspectorPerformance = collect([
                'Sin datos' => 0
            ]);
        }

        // 4. Inspecciones a lo largo del tiempo (último año)
        $inspectionsOverTime = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M Y');
            $count = Inspection::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $inspectionsOverTime[$monthName] = $count;
        }

        // Datos para el Calendario
        $startDate = Carbon::now()->startOfMonth()->subMonth();
        $endDate = Carbon::now()->endOfMonth()->addMonth();

        // Obtener TODAS las inspecciones del rango de fechas
        $allInspections = Inspection::with(['project', 'user'])
            ->where(function ($query) use ($startDate, $endDate) {
                // Inspecciones programadas: usar fecha_programada
                $query->whereNotNull('fecha_programada')
                    ->where('fecha_programada', '>=', $startDate)
                    ->where('fecha_programada', '<=', $endDate);
            })
            ->orWhere(function ($query) use ($startDate, $endDate) {
                // Inspecciones no programadas: usar fecha
                $query->whereNull('fecha_programada')
                    ->whereNotNull('fecha')
                    ->where('fecha', '>=', $startDate)
                    ->where('fecha', '<=', $endDate);
            })
            ->get()
            ->map(function ($inspection) {
                $projectName = $inspection->project ? $inspection->project->name : 'Sin proyecto';
                
                // Determinar la fecha a usar y el tipo de inspección
                $isProgrammed = !is_null($inspection->fecha_programada);
                $displayDate = $isProgrammed 
                    ? Carbon::parse($inspection->fecha_programada)->format('Y-m-d')
                    : Carbon::parse($inspection->fecha)->format('Y-m-d');

                // Determinar color y título según el estado
                if ($isProgrammed) {
                    // Inspecciones programadas: color según prioridad
                    $color = match($inspection->prioridad) {
                        1 => '#ef4444', // Rojo para alta prioridad
                        2 => '#f59e0b', // Ámbar para media prioridad
                        3 => '#10b981', // Verde para baja prioridad
                        default => '#6b7280' // Gris por defecto
                    };
                    $title = "✅ Programada #{$inspection->code} - {$projectName}";
                    $status = 'Programada';
                } else {
                    // Inspecciones no programadas: púrpura
                    $color = '#9333ea';
                    $title = "⏳ Pendiente #{$inspection->code} - {$projectName}";
                    $status = 'Pendiente de Programación';
                }

                return [
                    'id' => $inspection->id,
                    'title' => $title,
                    'start' => $displayDate,
                    'color' => $color,
                    'type' => $isProgrammed ? 'programmed' : 'unprogrammed',
                    'inspection' => [
                        'id' => $inspection->id,
                        'code' => $inspection->code,
                        'project_name' => $projectName,
                        'tipo' => $inspection->tipo,
                        'inspector' => $inspection->user ? $inspection->user->name : 'Sin asignar',
                        'solicitante' => $inspection->solicitante,
                        'supervisor' => $inspection->supervisor,
                        'prioridad' => $inspection->prioridad,
                        'fecha_programada' => $inspection->fecha_programada,
                        'fecha' => $inspection->fecha,
                        'descripcion' => $inspection->descripcion,
                        'gerencia' => $inspection->gerencia,
                        'status' => $status
                    ]
                ];
            });

        // Combinar todas las inspecciones para el calendario
        $calendarEvents = $allInspections->toArray();

        // Preparar datos para los gráficos en formato Chart.js
        $chartData = [
            'inspectionsByType' => [
                'labels' => array_keys($inspectionsByType->toArray()),
                'datasets' => [[
                    'data' => array_values($inspectionsByType->toArray()),
                    'backgroundColor' => [
                        '#3b82f6', '#ef4444', '#10b981', '#f59e0b', 
                        '#8b5cf6', '#06b6d4', '#84cc16', '#f97316'
                    ]
                ]]
            ],
            'inspectionsByStatus' => [
                'labels' => array_keys($inspectionsByStatus),
                'datasets' => [[
                    'data' => array_values($inspectionsByStatus),
                    'backgroundColor' => ['#3b82f6', '#f59e0b', '#10b981', '#6b7280']
                ]]
            ],
            'inspectorPerformance' => [
                'labels' => array_keys($inspectorPerformance->toArray()),
                'datasets' => [[
                    'label' => 'Inspecciones Completadas',
                    'data' => array_values($inspectorPerformance->toArray()),
                    'backgroundColor' => '#3b82f6'
                ]]
            ],
            'inspectionsOverTime' => [
                'labels' => array_keys($inspectionsOverTime),
                'datasets' => [[
                    'label' => 'Inspecciones Creadas',
                    'data' => array_values($inspectionsOverTime),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4
                ]]
            ]
        ];

        return Inertia::render('Dashboard/Index', [
            'kpis' => [
                'totalInspections' => $totalInspections,
                'completedInspections30Days' => $completedInspections30Days,
                'activeInspectors' => $activeInspectors,
                'upcomingInspections7Days' => $upcomingInspections7Days,
            ],
            'chartData' => $chartData,
            'calendarEvents' => $calendarEvents,
        ]);
    }
}
