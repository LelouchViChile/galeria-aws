<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;

class SlideController extends Controller
{
    public function index()
    {
        $items = Slide::all();
        // Asegúrate de que 'welcome' sea el nombre de tu vista principal
        return view('welcome', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('img_slides', 'public');

            Slide::create([
                'titulo' => $request->titulo,
                'ruta' => $path
            ]);
        }

        return back()->with('success', 'Slide agregado correctamente.');
    }
}
