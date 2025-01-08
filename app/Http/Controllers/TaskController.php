<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Inspection;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspections = Inspection::all(); //cambiarlo con has role "inspector"
        if (request()->wantsJson()) {
            return response()->json($inspections);
        }
        return Inertia::render('Tasks/index', ['inspections' => $inspections]);
    }
}
