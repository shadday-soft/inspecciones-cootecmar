<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\InspectionCreateController;
use App\Http\Controllers\pdf\ExportController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')
        ->middleware('permission:acceso dashboard');

    // Rutas de herramientas/equipos
    Route::resource('tools', ToolController::class)->middleware('permission:ver equipos');
    Route::resource('tools', ToolController::class)->only(['create', 'store'])
        ->middleware('permission:crear equipos');
    Route::resource('tools', ToolController::class)->only(['edit', 'update'])
        ->middleware('permission:editar equipos');
    Route::resource('tools', ToolController::class)->only(['destroy'])
        ->middleware('permission:eliminar equipos');

    // Rutas de inspecciones
    Route::resource('inspections', InspectionController::class)->middleware('permission:ver inspecciones');
    Route::resource('inspections', InspectionController::class)->only(['create', 'store'])
        ->middleware('permission:crear inspecciones');
    Route::resource('inspections', InspectionController::class)->only(['edit', 'update'])
        ->middleware('permission:editar inspecciones');
    Route::resource('inspections', InspectionController::class)->only(['destroy'])
        ->middleware('permission:eliminar inspecciones');

    // Rutas de usuarios
    Route::resource('users', UserController::class)->middleware('permission:ver usuarios');

    // Rutas de proyectos
    Route::resource('projects', ProjectController::class)->middleware('permission:ver proyectos');
    Route::resource('projects', ProjectController::class)->only(['create', 'store'])
        ->middleware('permission:crear proyectos');
    Route::resource('projects', ProjectController::class)->only(['edit', 'update'])
        ->middleware('permission:editar proyectos');
    Route::resource('projects', ProjectController::class)->only(['destroy'])
        ->middleware('permission:eliminar proyectos');

    Route::get('getDateInspections', [InspectionController::class, 'getDateInspections'])->name('getDateInspections');
    Route::post('inspectionAssing/{inspection}', [InspectionController::class, 'assing'])->name('inspection.assing')
        ->middleware('permission:asignar inspecciones');

    // Rutas de tareas
    Route::resource('tasks', TaskController::class)->middleware('permission:ver tareas');
    Route::resource('tasks', TaskController::class)->only(['create', 'store'])
        ->middleware('permission:crear tareas');
    Route::resource('tasks', TaskController::class)->only(['edit', 'update'])
        ->middleware('permission:editar tareas');
    Route::resource('tasks', TaskController::class)->only(['destroy'])
        ->middleware('permission:eliminar tareas');

    Route::get('getTasksByInspection/{inspection}', [TaskController::class, 'getTasksByInspection'])->name('getTasksByInspection');
    Route::get('settings', [UserController::class, 'settings'])->name('settings');
    Route::post('users/signature', [UserController::class, 'signature'])->name('users.signature');

    // Rutas de reportes
    Route::resource('reports', ReportController::class)->middleware('permission:ver reportes');
    
    Route::resource('reports', ReportController::class)->only(['create', 'store'])
        ->middleware('permission:crear reportes');
    Route::resource('reports', ReportController::class)->only(['edit', 'update'])
        ->middleware('permission:editar reportes');
    Route::resource('reports', ReportController::class)->only(['destroy'])
        ->middleware('permission:eliminar reportes');

    // Rutas para gestión de roles y permisos
    Route::middleware('permission:ver roles')->group(function () {
        Route::resource('roles', RoleController::class)->only(['index', 'show']);
    });
    Route::middleware('permission:crear roles')->group(function () {
        Route::resource('roles', RoleController::class)->only(['create', 'store']);
    });
    Route::middleware('permission:editar roles')->group(function () {
        Route::resource('roles', RoleController::class)->only(['edit', 'update']);
    });
    Route::middleware('permission:eliminar roles')->group(function () {
        Route::resource('roles', RoleController::class)->only(['destroy']);
    });

    Route::middleware('permission:ver permisos')->group(function () {
        Route::resource('permissions', PermissionController::class)->only(['index', 'show']);
    });
    Route::middleware('permission:crear permisos')->group(function () {
        Route::resource('permissions', PermissionController::class)->only(['create', 'store']);
    });
    Route::middleware('permission:editar permisos')->group(function () {
        Route::resource('permissions', PermissionController::class)->only(['edit', 'update']);
    });
    Route::middleware('permission:eliminar permisos')->group(function () {
        Route::resource('permissions', PermissionController::class)->only(['destroy']);
    });

    Route::post('roles/{role}/assign-user', [RoleController::class, 'assignToUser'])->name('roles.assign-user')
        ->middleware('permission:gestionar roles usuarios');
    Route::delete('roles/{role}/remove-user', [RoleController::class, 'removeFromUser'])->name('roles.remove-user')
        ->middleware('permission:gestionar roles usuarios');
    Route::get('users/{user}/roles', [UserController::class, 'manageRoles'])->name('users.manage-roles')
        ->middleware('permission:gestionar roles usuarios');
    Route::post('users/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign-roles')
        ->middleware('permission:gestionar roles usuarios');

    // Rutas de auditoría
    Route::middleware('permission:audit.view')->group(function () {
        Route::get('audit', [AuditController::class, 'index'])->name('audit.index');
        Route::get('audit/{audit}', [AuditController::class, 'show'])->name('audit.show');
        Route::get('audit-stats', [AuditController::class, 'stats'])->name('audit.stats');
    });

    Route::name('export.')->controller(ExportController::class)->group(function () {
        Route::get('report-inspection/{report}', 'export')->name('report-inspeccion')
            ->middleware('permission:exportar reportes');
    });

    Route::post('upload/reports/images/', [InspectionCreateController::class, 'uploadImage'])->name('upload.photos');
});

/*
    tools.index
    Create
    Store
    Show
    Edit
    Update
    Destroy
*/
