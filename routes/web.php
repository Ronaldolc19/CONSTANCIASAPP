<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CarreraController, EstudianteController, EmpresaController, PeriodoController, ConstanciaController};
use App\Http\Controllers\HomeController;
use App\Models\Empresa;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');

    Route::resource('carreras', CarreraController::class);
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('empresas', EmpresaController::class);
    Route::resource('periodos', PeriodoController::class);
    Route::resource('constancias', ConstanciaController::class);

    // RUTA PARA GENERAR NÚMEROS
    Route::get('/constancias/generar/numeros', 
        [ConstanciaController::class, 'generarNumeros']
    )->name('constancias.generar.numeros');
    // 2️⃣ VISTA GENERAL DE CONSTANCIAS
    Route::get('/constancias-general', 
        [ConstanciaController::class, 'vistaGeneral']
    )->name('constancias.general');

    Route::get('/constancias/{id}/docx', 
    [ConstanciaController::class, 'generarDOCX']
    )->name('constancias.docx');

    // 4️⃣ HISTORIAL DE GENERACIÓN
    Route::get('/constancias/{id}/historial', 
        [ConstanciaController::class, 'historial']
    )->name('constancias.historial');

});