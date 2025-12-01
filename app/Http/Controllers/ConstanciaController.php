<?php

namespace App\Http\Controllers;
use App\Models\Constancia;
use App\Models\Estudiante;
use App\Models\Empresa;
use App\Models\Periodo;
use App\Models\Carrera;
use App\Http\Requests\StoreConstanciaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\IOFactory;
use ZipArchive;
use Phpdocx\Create\CreateDocxFromTemplate;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Settings;

class ConstanciaController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        $constancias = Constancia::with(['estudiante.carrera','empresa','periodo'])
            ->orderBy('id_constancia','DESC')
            ->get();

        return view('constancias.index', compact('constancias'));
    }

    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre')->get();
        $empresas = Empresa::orderBy('nombre')->get();
        $periodos = Periodo::orderBy('fecha_inicio')->get();

        return view('constancias.create', compact('estudiantes','empresas','periodos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_estudiante' => 'required',
            'id_empresa' => 'required',
            'id_periodo' => 'required',
            'no_registro' => 'required|unique:constancias,no_registro',
            'no_folio' => 'required|unique:constancias,no_folio',
            'calificacion' => 'required'
        ]);

        Constancia::create([
            'id_estudiante' => $request->id_estudiante,
            'id_empresa' => $request->id_empresa,
            'id_periodo' => $request->id_periodo,
            'no_registro' => $request->no_registro,
            'no_folio' => $request->no_folio,
            'calificacion' => $request->calificacion,
            'fecha_emision' => $request->fecha_emision
                                ?: Carbon::now()->format('Y-m-d')
        ]);

        return redirect()->route('constancias.index')->with('success','Constancia registrada.');
    }

    public function edit($id)
    {
        $constancia = Constancia::findOrFail($id);

        $estudiantes = Estudiante::orderBy('nombre')->get();
        $empresas = Empresa::orderBy('nombre')->get();
        $periodos = Periodo::orderBy('fecha_inicio')->get();

        return view('constancias.edit', compact('constancia','estudiantes','empresas','periodos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_estudiante' => 'required',
            'id_empresa' => 'required',
            'id_periodo' => 'required',
            'calificacion' => 'required',
            'no_registro' => 'required|unique:constancias,no_registro,' . $id . ',id_constancia',
            'no_folio' => 'required|unique:constancias,no_folio,' . $id . ',id_constancia',
        ]);

        $constancia = Constancia::findOrFail($id);

        $constancia->update([
            'id_estudiante' => $request->id_estudiante,
            'id_empresa' => $request->id_empresa,
            'id_periodo' => $request->id_periodo,
            'no_registro' => $request->no_registro,
            'no_folio' => $request->no_folio,
            'calificacion' => $request->calificacion,
            'fecha_emision' => $request->fecha_emision ?: $constancia->fecha_emision
        ]);

        return redirect()->route('constancias.index')->with('success','Constancia actualizada.');
    }

    public function show($id)
    {
        $constancia = Constancia::with(['estudiante','empresa','periodo'])
            ->findOrFail($id);

        return view('constancias.show', compact('constancia'));
    }

    public function destroy($id)
    {
        Constancia::findOrFail($id)->delete();
        return redirect()->route('constancias.index')->with('success','Constancia eliminada.');
    }

    // Generador AJAX
    public function generarNumeros()
    {
        $no_registro = \App\Models\Constancia::generarNumeroRegistro();
        $no_folio    = \App\Models\Constancia::generarNumeroFolio();

        return response()->json([
            'no_registro' => $no_registro,
            'no_folio' => $no_folio
        ]);
    }
    public function vistaGeneral(Request $request)
    {
        $query = Constancia::with(['estudiante.carrera', 'empresa', 'periodo']);

        // Búsqueda
        if ($request->q) {
            $q = $request->q;
            $query->whereHas('estudiante', function($est) use ($q) {
                $est->where('nombre', 'LIKE', "%$q%")
                    ->orWhere('ap', 'LIKE', "%$q%")
                    ->orWhere('am', 'LIKE', "%$q%")
                    ->orWhere('no_cuenta', 'LIKE', "%$q%");
            })
            ->orWhere('no_registro', 'LIKE', "%$q%")
            ->orWhere('no_folio', 'LIKE', "%$q%");
        }

        

        $constancias = $query->orderBy('id_constancia', 'DESC')->get();

        return view('constancias.general', compact('constancias'));
    }
    
public function generarDOCX($id)
{
    $constancia = Constancia::with(['estudiante.carrera', 'empresa', 'periodo'])
        ->findOrFail($id);

    // ================================
    // 🔹 FECHA DE EMISIÓN
    // ================================
    $fechaEmision = Carbon::parse($constancia->fecha_emision ?? now())
        ->locale('es')
        ->translatedFormat('d \d\e F \d\e Y');

    // ================================
    // 🔹 NOMBRE COMPLETO
    // ================================
    $nombreCompleto =
        $constancia->estudiante->nombre . ' ' .
        $constancia->estudiante->ap . ' ' .
        $constancia->estudiante->am;

    // ================================
    // 🔹 ALUMNO / ALUMNA
    // ================================
    $genero = strtolower($constancia->estudiante->genero);
    $alumn = ($genero === 'f') ? 'la alumna' : 'el alumno';
    $adscr = ($genero === 'f') ? 'adscrita' : 'adscrito';

    // ================================
    // 🔹 PERIODO FORMATEADO
    // ================================
    $inicio = Carbon::parse($constancia->periodo->fecha_inicio)->locale('es');
    $fin    = Carbon::parse($constancia->periodo->fecha_fin)->locale('es');

    $periodoFormato =
        $inicio->translatedFormat('d \d\e F \d\e Y') .
        ' al ' .
        $fin->translatedFormat('d \d\e F \d\e Y');

    // ================================
    // 🔹 VARIABLES DE REEMPLAZO
    // ================================
    $variables = [
        '{{NOMBRE}}'       => $nombreCompleto,
        '{{ALU}}'          => $alumn,
        '{{CARRERA}}'      => $constancia->estudiante->carrera->nombre,
        '{{NO_CUENTA}}'    => $constancia->estudiante->no_cuenta,
        '{{EMPRESA}}'      => $constancia->empresa->nombre,
        '{{PERIODO}}'      => $periodoFormato,
        '{{ADSCR}}'        => $adscr,
        '{{FECHA_EMISION}}'=> $fechaEmision,
        '{{NO_REGISTRO}}'  => $constancia->no_registro,
    ];

    // ================================
    // 🔹 RUTA DE LA PLANTILLA
    // ================================
    $templatePath = storage_path('app/plantillas/CONSTANCIAUP.docx');

    if (!file_exists($templatePath)) {
        return response()->json(["error" => "No se encontró la plantilla DOCX"]);
    }

    // ================================
    // 🔹 CARPETA TEMPORAL
    // ================================
    $tempDir = storage_path('app/temp');
    if (!file_exists($tempDir)) mkdir($tempDir, 0777, true);

    $tempFile = "$tempDir/constancia_$id.docx";

    copy($templatePath, $tempFile);

    // ================================
    // 🔹 ABRIR DOCX COMO ZIP Y REEMPLAZAR
    // ================================
    $zip = new \ZipArchive;

    if ($zip->open($tempFile) === TRUE) {

        $xml = $zip->getFromName('word/document.xml');

        if (!$xml) {
            return response()->json(["error" => "No se pudo leer document.xml dentro del DOCX"]);
        }

        foreach ($variables as $key => $value) {
            $xml = str_replace($key, $value, $xml);
        }

        $zip->addFromString('word/document.xml', $xml);
        $zip->close();

    } else {
        return response()->json(["error" => "No se pudo abrir archivo DOCX con ZipArchive"]);
    }

    // ================================
    // 🔹 EXPORTAR A PDF EN storage/app/pdf
    // ================================
    $pdfDir = storage_path("app/pdf");
    if (!file_exists($pdfDir)) mkdir($pdfDir, 0777, true);

    $pdfPath = "$pdfDir/constancia_$id.pdf";

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $soffice = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';
    } else {
        $soffice = '/usr/bin/libreoffice';
    }

    $command = "$soffice --headless --nologo --nofirststartwizard --convert-to pdf \"$tempFile\" --outdir \"$pdfDir\" 2>&1";

    exec($command, $output, $exitCode);

    if (!file_exists($pdfPath)) {
        return response()->json([
            "error"    => "LibreOffice no generó el PDF",
            "comando"  => $command,
            "exitCode" => $exitCode,
            "logs"     => $output
        ]);
    }

    // Registrar historial
    $this->agregarHistorial($id, "generado");

    return back()->with("success", "Constancia generada correctamente.");
}


    private function agregarHistorial($id_constancia, $accion)
    {
        \App\Models\HistorialConstancia::create([
            'id_constancia' => $id_constancia,
            'id_usuario'    => auth()->id(),
            'accion'        => $accion,
            'fecha'         => now(),
        ]);
    }
    public function historial($id)
    {
        $constancia = Constancia::with(['estudiante', 'historial.usuario'])
            ->findOrFail($id);

        return view('constancias.historial', compact('constancia'));
    }
    public function verPDF($id)
    {
        $constancia = Constancia::findOrFail($id);

        // Ruta donde guardas tus PDFs generados
        $pdfPath = storage_path("app/pdf/constancia_$id.pdf");

        if (!file_exists($pdfPath)) {
            return back()->with('error', 'Aún no se ha generado el PDF de esta constancia.');
        }

        // Registrar historial
        $this->agregarHistorial($id, "visualizado");

        return response()->file($pdfPath); // <-- ABRE EL PDF DIRECTO
    }

    public function descargarPDF($id)
    {
        $constancia = Constancia::findOrFail($id);

        $pdfPath = storage_path("app/pdf/constancia_$id.pdf");

        if (!file_exists($pdfPath)) {
            return back()->with('error', 'El PDF aún no ha sido generado.');
        }

        // Registrar historial
        $this->agregarHistorial($id, "descargado");

        return response()->download($pdfPath, "Constancia_$id.pdf");
    }

}
