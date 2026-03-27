<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Constancia;
use App\Models\Carrera;
use App\Models\Empresa;
use App\Models\Periodo;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\ConstanciasExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KPIs HISTÓRICOS (Solo las que ya fueron EMITIDAS en toda la historia)
        $totalConstancias = Constancia::where('estado', 'emitida')->count();
        $totalEstudiantes = Estudiante::count();
        $totalEmpresas = Empresa::count();
        $totalPeriodos = Periodo::count();

        // 2. DATOS CICLO ACTUAL (Solo EMITIDAS y NO archivadas)
        $reportePeriodos = Periodo::withCount(['estudiantes as total' => function($q) {
            $q->whereHas('constancias', function($c) { 
                $c->where('archivado', false)->where('estado', 'emitida'); 
            });
        }])->having('total', '>', 0)->get();

        $periodosLabels = $reportePeriodos->map(fn($p) => 
            Carbon::parse($p->fecha_inicio)->format('d/m/y')
        )->toArray();

        // Filtro por Carrera: Solo cuenta constancias emitidas y activas
        $reporteCarreras = Carrera::whereHas('estudiantes.constancias', function($q){
            $q->where('archivado', false)->where('estado', 'emitida');
        })->withCount(['estudiantes as constancias_count' => function($q) {
            $q->whereHas('constancias', function($c) { 
                $c->where('archivado', false)->where('estado', 'emitida'); 
            });
        }])->get();

        // Filtro por Empresa: Solo cuenta alumnos con constancia emitida
        $reporteEmpresas = Empresa::whereHas('estudiantes.constancias', function($q){
            $q->where('archivado', false)->where('estado', 'emitida');
        })->withCount(['estudiantes as total' => function($q) {
            $q->whereHas('constancias', function($c) { 
                $c->where('archivado', false)->where('estado', 'emitida'); 
            });
        }])->orderBy('total', 'desc')->take(10)->get();

        return view('dashboard.index', compact(
            'totalConstancias', 'totalEstudiantes', 'totalEmpresas', 'totalPeriodos'
        ) + [
            'periodosLabels' => $periodosLabels, 
            'periodosData' => $reportePeriodos->pluck('total')->toArray(),
            'carrerasLabels' => $reporteCarreras->pluck('nombre')->toArray(),
            'carrerasData' => $reporteCarreras->pluck('constancias_count')->toArray(),
            'empresasLabels' => $reporteEmpresas->pluck('nombre')->toArray(),
            'empresasData' => $reporteEmpresas->pluck('total')->toArray(),
        ]);
    }

    public function generarPDF(Request $request)
    {
        // El PDF solo debe mostrar lo EMITIDO y ACTIVO
        $totalEmitidasActivas = Constancia::where('archivado', false)
                                          ->where('estado', 'emitida')
                                          ->count();
        
        $reporteCarreras = Carrera::whereHas('estudiantes.constancias', function($q){
            $q->where('archivado', false)->where('estado', 'emitida');
        })->withCount(['estudiantes as constancias_count' => function($q) {
            $q->whereHas('constancias', function($c) { 
                $c->where('archivado', false)->where('estado', 'emitida'); 
            });
        }])->get();

        $reporteEmpresas = Empresa::whereHas('estudiantes.constancias', function($q){
            $q->where('archivado', false)->where('estado', 'emitida');
        })->withCount(['estudiantes as total' => function($q) {
            $q->whereHas('constancias', function($c) { 
                $c->where('archivado', false)->where('estado', 'emitida'); 
            });
        }])->orderBy('total', 'desc')->take(10)->get();

        $data = [
            'totalConstancias' => $totalEmitidasActivas,
            'reporteCarreras'  => $reporteCarreras,
            'reporteEmpresas'  => $reporteEmpresas,
            'imgPeriodos'      => $request->input('imgPeriodos'),
            'imgCarreras'      => $request->input('imgCarreras'),
            'imgEmpresas'      => $request->input('imgEmpresas'),
            'fecha'            => now()->translatedFormat('d \d\e F, Y')
        ];

        $nombreArchivo = 'Informe_Tecnico_' . now()->format('Y_m_d') . '.pdf';
        return Pdf::loadView('reports.dashboard_pdf', $data)->download($nombreArchivo);
    }

    public function reiniciarCiclo()
    {
        // Solo afecta a las gráficas porque las "mueve" al historial (archivado = true)
        // Pero no borra los registros de la base de datos, por eso las Cards siguen sumando.
        Constancia::where('archivado', false)->update(['archivado' => true]);
        
        return redirect()->route('dashboard.index')->with('success', 'Ciclo finalizado: Las gráficas se han reiniciado, pero el historial global se mantiene intacto.');
    }
}