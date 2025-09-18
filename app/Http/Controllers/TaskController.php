<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Inspection;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;

        $inspections = Inspection::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->orWhereHas('ayudantes', function ($subQuery) use ($userId) {
                    $subQuery->where('ayudante_id', $userId);
                });
        })
            ->with('user', 'ayudante', 'ayudantes', 'tools')
            ->get();

        if (request()->wantsJson()) {
            return response()->json($inspections);
        }

        return Inertia::render('Tasks/index', ['inspections' => $inspections]);
    }

    public function getTasksByInspection(Inspection $inspection)
    {
        try {
            $tasks = Task::where('inspection_id', $inspection->id)->get();

            return response()->json($tasks);
        } catch (Exception $e) {
            return back()->withErrors('message', 'Ocurrio un Error Al obtener las tareas : '.$e);
        }
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
    public function store(StoreTaskRequest $request)
    {
        $validateData = $request->validated();
        try {
            $validateData['user_id'] = Inspection::find($validateData['inspection_id'])->user_id;
            $validateData['percentDone'] = 0;
            $task = Task::create($validateData);

            return response()->json(['message' => 'Tarea Creada', 'task' => $task], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Ocurrio un Error Al Crear : '.$e]);
            // return back()->withErrors('message', 'Ocurrio un Error Al Crear : ' . $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validateData = $request->validated();
        try {
            $task->update($validateData);
        } catch (Exception $e) {
            return back()->withErrors('message', 'Ocurrio un Error Al Actualizar : '.$e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
        } catch (Exception $e) {
            return back()->withErrors('message', 'Ocurrio un Error Al eliminar : '.$e);
        }
    }
}
