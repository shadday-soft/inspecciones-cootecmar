<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        if (request()->wantsJson()) {
            return response()->json($users);
        }
        
        return Inertia::render('Users/index', [
            'users' => $users
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function settings()
    {
        $user = auth()->user();

        return Inertia::render('Users/settings', [ 'user' => $user]);
    }

    public function signature(Request $request)
    {
        $signature = $request->signature;
        if (is_string($signature)) {
            // Imagen base64 a imagen .png
            $exploded = explode(',', $signature);
            $decoded = base64_decode($exploded[1]);
            $filename = 'signature-' . time() . '.' . 'png';
            // Almacenar imagen en storage
            file_put_contents('storage/signatures/' . $filename, $decoded);

            $this->saveSignature('signatures/' . $filename);
        }
        else {
            $request->validate([
                'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            $path = $request->file('signature')->store('signatures', 'public');
            $this->saveSignature($path);
        }
        return back()
            ->with('success','You have successfully upload image.');
    }

    function saveSignature($path)
    {
        $user = User::find(auth()->user()->id);
        if ($user->signature) {
            Storage::disk('public')->delete($user->signature);
        }
        $user->signature = $path;
        $user->save();

        return;
    }
}
