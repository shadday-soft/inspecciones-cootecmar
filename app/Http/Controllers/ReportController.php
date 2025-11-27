<?php

namespace App\Http\Controllers;

use App\Models\FieldReport;
use App\Models\Inspection;
use App\Models\Report;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $query = Report::with('user');
            if ($request->inspection_id) {
                $query->where('inspection_id', $request->inspection_id);
            }
            $reports = $query->get();

            return response()->json($reports);
        }
        $reports = Report::get();
        // return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $inspectionId = $request->get('inspection_id');

        if (! $inspectionId) {
            return redirect()->route('inspections.index')
                ->with('error', 'Se requiere una inspección para crear un reporte');
        }

        $inspeccion = Inspection::with(['project', 'tools', 'user'])->findOrFail($inspectionId);
        $users = User::all();

        return Inertia::render('Reports/CreatePage', [
            'inspeccion' => $inspeccion,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validateData = $request->validated();
        try {
            DB::beginTransaction();
            $report = Report::create([
                'user_id' => auth()->user()->id,
                'inspection_id' => $request->inspection_id,
                'type' => $request->type,
                'status' => 'Listo',
                'consecutive' => Report::count() + 1,
                // 'signature_creator' => $request->signature_creator,
                // 'signature_reviewed' => $request->signature_reviewed,
            ]);
            foreach ($request->inputs as $field_report) {
                $value = $field_report['value'];
                if (is_array($field_report['value'])) {
                    $value = json_encode($field_report['value']);
                }

                FieldReport::create([
                    'report_id' => $report->id,
                    'field' => $field_report['label'],
                    'label' => $field_report['textLabel'],
                    'value' => $value,
                ]);
            }

            DB::commit();
            // Report::create($validateData);
        } catch (Exception $e) {
            DD($e);

            return back()->withErrors('message', 'Ocurrio un Error Al Crear : '.$e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $validateData = $request->validate([
            //
        ]);

        try {
            $report->update($validateData);
        } catch (Exception $e) {
            return back()->withErrors('message', 'Ocurrio un Error Al Actualizar : '.$e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        try {
            $report->delete();

            return redirect()->back()->with('success', 'Reporte eliminado correctamente');
        } catch (Exception $e) {
            return back()->withErrors('message', 'Ocurrió un error al eliminar: '.$e->getMessage());
        }
    }
}
