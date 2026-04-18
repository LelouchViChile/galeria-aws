<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// 1. IMPORTACIÓN DE LA HERRAMIENTA
// Le dice a este archivo dónde encontrar la clase "Schema" de Laravel, 
// la cual es el "maestro constructor" encargado de crear y modificar las tablas en la base de datos.
// Sin esta línea, PHP no sabría qué significa "Schema" más abajo.
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        // 2. EL LÍMITE DE SEGURIDAD PARA MYSQL
// Le indica al "Schema" que, a partir de ahora, el tamaño por defecto de los textos (VARCHAR) será de 191 caracteres.
// Se usa exactamente 191 porque, al multiplicarlo por los 4 bytes que pesa cada letra/emoji en utf8mb4,
// nos da 764 bytes, quedando justo por debajo del límite máximo de 767 bytes que permiten las 
// versiones antiguas de MySQL para columnas "Únicas" (evitando así el error 1071).
    }
}
