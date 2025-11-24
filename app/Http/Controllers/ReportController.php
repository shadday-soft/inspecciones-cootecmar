<?php

namespace App\Http\Controllers;

use App\Models\FieldReport;
use App\Models\Report;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->expectsJson()){
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validateData = $request->validated();
        try{
            DB::beginTransaction();
           $report =  Report::create([
                'user_id' => auth()->user()->id,
                'inspection_id' => $request->inspection_id,
                'type' => $request->type,
                'status' => 'Listo',
                'consecutive' => Report::count() +1,
                // 'signature_creator' => $request->signature_creator,
                // 'signature_reviewed' => $request->signature_reviewed,
            ]);
            foreach($request->inputs as $field_report){
                $value = $field_report['value'];
                if(is_array($field_report['value'])){
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
        }catch(Exception $e){
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

        try{
            $report->update($validateData);
        }catch(Exception $e){
            return back()->withErrors('message', 'Ocurrio un Error Al Actualizar : '.$e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        try{
            $report->delete();
        }catch(Exception $e){
            return back()->withErrors('message', 'Ocurrio un Error Al eliminar : '.$e);
        }
    }
}
