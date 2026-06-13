<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $items = Slide::all();
        return view('welcome', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'imagen' => 'required|image|max:10240' // Lo dejé en 10MB por si acaso
        ]);

        if ($request->hasFile('imagen')) {
            // 1. Sube la foto a tu bucket en AWS S3
            $path = $request->file('imagen')->store('img_slides', 's3');

            // 2. Guarda el registro en tu base de datos RDS
            Slide::create([
                'titulo' => $request->titulo,
                'ruta' => $path
            ]);
        }

        // 3. Te devuelve a la vista con el mensaje de éxito
        return back()->with('success', '¡Slide guardado en S3 y RDS correctamente!');
    }
}
