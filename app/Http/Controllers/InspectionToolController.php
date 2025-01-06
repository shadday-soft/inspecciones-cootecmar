<?php

namespace App\Http\Controllers;

use App\Models\InspectionTool;
use Exception;
use Illuminate\Http\Request;

class InspectionToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validateData = $request->validated();

        try{
            InspectionTool::create($validateData);
        }catch(Exception $e){
            return back()->withErrors('message', 'Ocurrio un Error Al Crear : '.$e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InspectionTool $inspectionTool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspectionTool $inspectionTool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspectionTool $inspectionTool)
    {
        $validateData = $request->validate([
            //
        ]);

        try{
            $inspectionTool->update($validateData);
        }catch(Exception $e){
            return back()->withErrors('message', 'Ocurrio un Error Al Actualizar : '.$e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspectionTool $inspectionTool)
    {
        try{
            $inspectionTool->delete();
        }catch(Exception $e){
            return back()->withErrors('message', 'Ocurrio un Error Al eliminar : '.$e);
        }
    }
}
