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
        // 1. Métricas Base (Solo lo NO archivado para que el Dashboard se limpie al reiniciar)
        $totalConstancias = Constancia::where('archivado', false)->count();
        $totalEstudiantes = Estudiante::count();
        $totalCarreras = Carrera::count();
        $totalEmpresas = Empresa::count();
        $totalPeriodos = Periodo::count();

        // 2. Datos Períodos (Etiquetas por fecha)
        $reportePeriodos = Periodo::withCount(['estudiantes as total' => function($q) {
            $q->whereHas('constancias', function($c) { $c->where('archivado', false); });
        }])->having('total', '>', 0)->get();

        $periodosLabels = $reportePeriodos->map(fn($p) => 
            \Carbon\Carbon::parse($p->fecha_inicio)->format('d/m/y') . ' - ' . \Carbon\Carbon::parse($p->fecha_fin)->format('d/m/y')
        )->toArray();

        // 3. Datos Carreras (Filtrado por no archivado)
        $reporteCarreras = Carrera::whereHas('estudiantes.constancias', function($q){
            $q->where('archivado', false);
        })->withCount(['estudiantes as constancias_count' => function($q) {
            $q->whereHas('constancias', function($c) { $c->where('archivado', false); });
        }])->get();

        // 4. Datos Empresas (Top 10 usadas actualmente)
        $reporteEmpresas = Empresa::whereHas('estudiantes.constancias', function($q){
            $q->where('archivado', false);
        })->withCount(['estudiantes as total' => function($q) {
            $q->whereHas('constancias', function($c) { $c->where('archivado', false); });
        }])->orderBy('total', 'desc')->take(10)->get();

        return view('dashboard.index', compact(
            'totalConstancias', 'totalEstudiantes', 'totalCarreras', 'totalEmpresas', 'totalPeriodos'
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
    // Datos para las tablas
    $totalConstancias = Constancia::where('archivado', false)->count();
    
    $reporteCarreras = Carrera::whereHas('estudiantes.constancias', function($q){
        $q->where('archivado', false);
    })->withCount(['estudiantes as constancias_count' => function($q) {
        $q->whereHas('constancias', function($c) { $c->where('archivado', false); });
    }])->get();

    // Nuevo: Datos de las Top 10 Empresas para la tabla del PDF
    $reporteEmpresas = Empresa::whereHas('estudiantes.constancias', function($q){
        $q->where('archivado', false);
    })->withCount(['estudiantes as total' => function($q) {
        $q->whereHas('constancias', function($c) { $c->where('archivado', false); });
    }])->orderBy('total', 'desc')->take(10)->get();

    $data = [
        'totalConstancias' => $totalConstancias,
        'reporteCarreras'  => $reporteCarreras,
        'reporteEmpresas'  => $reporteEmpresas,
        'imgPeriodos'      => $request->input('imgPeriodos'),
        'imgCarreras'      => $request->input('imgCarreras'),
        'imgEmpresas'      => $request->input('imgEmpresas'), // Nueva imagen
        'fecha'            => now()->format('d/m/Y H:i A')
    ];

    $pdf = Pdf::loadView('reports.dashboard_pdf', $data);
    return $pdf->download('Informe_Tecnico_Completo.pdf');
}

    public function reiniciarCiclo()
    {
        // Archivamos todas las constancias activas
        Constancia::where('archivado', false)->update(['archivado' => true]);
        return redirect()->route('dashboard.index')->with('success', 'Ciclo reiniciado. Los datos se han movido al histórico.');
    }
}