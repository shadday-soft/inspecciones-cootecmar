<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\TaskController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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

    Route::get('pdf/test', function () {
        $data = [
            'to' => 'Sam Example',
            'subtotal' => '5.00',
            'tax' => '.35',
            'total' => '5.35'
        ];

        $pdf = Pdf::loadView('pdf.invoice', $data);

        # Option 1) Show the PDF in the browser
        return $pdf->stream();
    })->name('pdf.test');
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
