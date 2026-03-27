<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CarreraController,
    EstudianteController,
    EmpresaController,
    PeriodoController,
    ConstanciaController,
    DashboardController,
    UserController
};

// 🔹 Página principal (opcional)
Route::get('/', function () {
    return redirect('/login');
});

// 🔹 RUTAS DE AUTENTICACIÓN (Laravel UI)
Auth::routes();

// -------------------------------------------------------------
// 🔹 USUARIOS LOGEADOS PERO SIN APROBAR
// -------------------------------------------------------------
Route::middleware(['auth', 'check.approved'])->group(function () {

    // 🔸 Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('role:admin');

    // ---------------------------------------------------------
    // 🔹 RUTAS SOLO PARA ADMIN
    // ---------------------------------------------------------
    Route::middleware(['role:admin'])->group(function () {
        // Ruta para la generación automática de folios y registros (AJAX)
        Route::get('/estudiantes/generar-numeros', 
            [App\Http\Controllers\EstudianteController::class, 'generarNumeros']
        )->name('estudiantes.generarNumeros');
        // CRUDs
        Route::resource('carreras', CarreraController::class);
        Route::resource('estudiantes', EstudianteController::class);
        Route::resource('empresas', EmpresaController::class);
        Route::resource('periodos', PeriodoController::class);
        Route::resource('constancias', ConstanciaController::class);

        // Usuarios (solo admin)
        Route::resource('usuarios', UserController::class);
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');

        Route::get('/usuarios/{id}/aprobar', [UserController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::get('/usuarios/{id}/desaprobar', [UserController::class, 'desaprobar'])->name('usuarios.desaprobar');

        Route::get('/usuarios/{id}/activar', [UserController::class, 'activar'])->name('usuarios.activar');
        Route::get('/usuarios/{id}/desactivar', [UserController::class, 'desactivar'])->name('usuarios.desactivar');

        Route::get('/usuarios/{id}/roles', [UserController::class, 'roles'])->name('usuarios.roles');
        Route::post('/usuarios/{id}/roles', [UserController::class, 'guardarRol'])->name('usuarios.roles.guardar');

        Route::get('/usuarios/{id}/permisos', [UserController::class, 'permisos'])->name('usuarios.permisos');
        Route::post('/usuarios/{id}/permisos', [UserController::class, 'guardarPermisos'])->name('usuarios.permisos.guardar');
        Route::get('/pendiente', function () {
            return view('pendiente'); // O el nombre de tu vista
        })->name('pendiente');

        // Constancias adicional
        Route::get('/constancias-general', 
            [ConstanciaController::class, 'vistaGeneral']
        )->name('constancias.general');

        // DOCX → PDF
        Route::get('/constancias/{id}/docx', 
            [ConstanciaController::class, 'generarDOCX']
        )->name('constancias.docx');

        // Historial
        Route::get('/constancias/{id}/historial',
            [ConstanciaController::class, 'historial']
        )->name('constancias.historial');

        // Ver y Descargar PDF
        Route::get('/constancias/{id}/ver',
            [ConstanciaController::class, 'verPDF']
        )->name('constancias.ver');

        Route::get('/constancias/{id}/descargar',
            [ConstanciaController::class, 'descargarPDF']
        )->name('constancias.descargar');

        Route::get('/dashboard/exportar', 
            [App\Http\Controllers\DashboardController::class, 'exportAndReset']
        )->name('constancias.export');

        Route::post('/dashboard/reporte-pdf', [DashboardController::class, 'generarPDF'])->name('dashboard.pdf');
        Route::post('/dashboard/reiniciar', [DashboardController::class, 'reiniciarCiclo'])->name('dashboard.reiniciar');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    });

});
