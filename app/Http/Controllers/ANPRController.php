<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ANPRController extends Controller
{
    //
    public function processImage(Request $request) {
        $image = $request->input('image');
        $imagePath = storage_path('app/public/plate.jpg');
        file_put_contents($imagePath, base64_decode($image));
    
        $output = shell_exec("python3 /path/to/anpr.py " . escapeshellarg($imagePath));
        return response()->json(['plate' => trim($output)]);
    }
    
}
