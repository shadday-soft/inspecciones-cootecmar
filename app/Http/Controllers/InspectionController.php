<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Exception;
use App\Http\Requests\StoreInspectionRequest;
use App\Http\Requests\UpdateInspectionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspections = Inspection::with('user', 'tools', 'ayudante')->get();
        $users = User::get();
        if (request()->wantsJson()) {
            return response()->json($inspections);
        }
        return Inertia::render('Inspections/index', ['inspections' => $inspections, 'users' => $users]);
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
    public function store(StoreInspectionRequest $request)
    {
        $validateData = $request->validated();

        try {
            Inspection::create($validateData);
        } catch (Exception $e) {
            return back()->withErrors('message', 'Ocurrio un Error Al Crear : ' . $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inspection $inspection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspection $inspection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInspectionRequest $request, Inspection $inspection)
    {
        $validateData = $request->validated();

        try {
            $inspection->update($validateData);
        } catch (Exception $e) {
            return back()->withErrors('message', 'Ocurrio un Error Al Actualizar : ' . $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection)
    {
        try {
            $inspection->delete();
        } catch (Exception $e) {
            return back()->withErrors('message', 'Ocurrio un Error Al eliminar : ' . $e);
        }
    }

    public function assing(Inspection $inspection, Request $request)
    {
        $validateData = $request->validate([
            'user_id' => 'required',
            // 'ayudante_id' => 'required',
            'tools' => 'nullable|array',
            'tools.*' => 'required|string|distinct|uuid',
        ]);
        $user = User::find($request->user_id);
        $ayudante = User::find($request->ayudante_id);
        $inspection->tools()->sync($validateData['tools']);

        if ($user && $ayudante) {
            unset($validateData['tools']);
            $inspection->update($validateData);
            return back()->with('message', 'Usuario y Ayudante Asignados Correctamente');
        } else {
            return back()->withErrors('message', 'Usuario o Ayudante No Encontrado');
        }
    }
}
