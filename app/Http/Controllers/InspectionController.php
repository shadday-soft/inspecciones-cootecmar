<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInspectionRequest;
use App\Http\Requests\UpdateInspectionRequest;
use App\Models\Inspection;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspections = Inspection::with('user', 'tools', 'ayudante', 'ayudantes', 'project')->get();
        $users = User::get();
        $projects = Project::get();
        if (request()->wantsJson()) {
            return response()->json($inspections);
        }

        // dd($inspections, $users);
        return Inertia::render('Inspections/index', [
            'inspections' => $inspections,
            'users' => $users,
            'projects' => $projects,
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
    public function store(StoreInspectionRequest $request)
    {
        $validateData = $request->validated();

        try {
            Inspection::create($validateData);
        } catch (Exception $e) {
            return back()->withErrors('message', 'Ocurrio un Error Al Crear : '.$e);
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
            return back()->withErrors('message', 'Ocurrio un Error Al Actualizar : '.$e);
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
            return back()->withErrors('message', 'Ocurrio un Error Al eliminar : '.$e);
        }
    }

    public function assing(Inspection $inspection, Request $request)
    {
        $validateData = $request->validate([
            'user_id' => 'required',
            'ayudante_ids' => 'nullable|array',
            'ayudante_ids.*' => 'required|distinct|numeric',
            'tools' => 'nullable|array',
            'tools.*' => 'required|distinct|uuid',
            'fecha_programada' => 'nullable|date',
            'duracion' => 'nullable|numeric',
        ]);

        $user = User::find($request->user_id);
        $inspection->tools()->sync($validateData['tools']);

        if ($user) {
            // Actualizar datos básicos de la inspección
            $inspection->update([
                'user_id' => $validateData['user_id'],
                'fecha_programada' => $validateData['fecha_programada'],
                'duracion' => $validateData['duracion'],
            ]);

            // Sincronizar ayudantes
            if (isset($validateData['ayudante_ids']) && is_array($validateData['ayudante_ids'])) {
                $inspection->ayudantes()->sync($validateData['ayudante_ids']);
            } else {
                $inspection->ayudantes()->detach();
            }

            return back()->with('message', 'Inspector y Ayudantes Asignados Correctamente');
        } else {
            return back()->withErrors('message', 'Inspector No Encontrado');
        }
    }

    public function getDateInspections()
    {
        $date = request('date');
        $inspections = Inspection::where('fecha', $date)->has('tools')->with('tools')->get();

        return response()->json($inspections);
    }
}
