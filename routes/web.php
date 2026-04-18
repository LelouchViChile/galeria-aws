<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SlideController; // <-- 1. Agregamos nuestro controlador
use Illuminate\Support\Facades\Route;

// --- 2. Modificamos la ruta principal para que cargue el carrusel ---
Route::get('/', [SlideController::class, 'index'])->name('home')->middleware('auth');

// --- 3. Nueva ruta para guardar las fotos en la base de datos ---
Route::post('/slides/guardar', [SlideController::class, 'store'])->name('slides.store')->middleware('auth');

// --- Tus rutas de Login originales intactas ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
