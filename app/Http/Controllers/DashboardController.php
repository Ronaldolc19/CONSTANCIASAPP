<?php

namespace App\Http\Controllers;
use App\Models\Estudiante;
use App\Models\Constancia;
use App\Models\Carrera;
use App\Models\Empresa;
use App\Models\Periodo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.index', [
        'totalConstancias' => Constancia::count(),
        'totalEstudiantes' => Estudiante::count(),
        'totalCarreras' => Carrera::count(),
        'totalEmpresas' => Empresa::count(),
        'totalPeriodos' => Periodo::count(),
    ]);
    }
}
