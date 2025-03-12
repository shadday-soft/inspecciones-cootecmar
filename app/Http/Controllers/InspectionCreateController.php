<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InspectionCreateController extends Controller
{
    public function uploadImage(Request $request)
    {
        DD($request->all());
        $url = '';
        if ($request->file('image')) {
            $url = Storage::putFile('public/reports/images', $request->image);
        }
        return response()->json([
            'url' => str_replace('public', 'storage', url($url))
        ], 200);
    }
}
