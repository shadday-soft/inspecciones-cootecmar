<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\InspectionCreateController;
use App\Http\Controllers\pdf\ExportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('tools', ToolController::class);
    Route::resource('inspections', InspectionController::class);
    Route::resource('users', UserController::class);
    Route::get('getDateInspections', [InspectionController::class, 'getDateInspections'])->name('getDateInspections');
    Route::post('inspectionAssing/{inspection}', [InspectionController::class, 'assing'])->name('inspection.assing');
    Route::resource('tasks', TaskController::class);
    Route::get('getTasksByInspection/{inspection}', [TaskController::class, 'getTasksByInspection'])->name('getTasksByInspection');
    Route::get('settings', [UserController::class, 'settings'])->name("settings");
    Route::post('users/signature', [UserController::class, 'signature'])->name('users.signature');
    Route::resource('reports', ReportController::class);

    Route::name('export.')->controller(ExportController::class)->group(function () {
        Route::get('report-inspection/{report}', 'export')->name('report-inspeccion');
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
