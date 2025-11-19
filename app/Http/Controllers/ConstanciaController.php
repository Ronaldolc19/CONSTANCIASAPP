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

        // Filtros
        if ($request->estado == 'pendientes') {
            $query->whereNull('fecha_emision');
        }
        if ($request->estado == 'emitidas') {
            $query->whereNotNull('fecha_emision');
        }

        $constancias = $query->orderBy('id_constancia', 'DESC')->get();

        return view('constancias.general', compact('constancias'));
    }
    
    public function generarDOCX($id)
{
    $constancia = Constancia::with(['estudiante.carrera','empresa','periodo'])
        ->findOrFail($id);

    // --- Género ---
    $genero = strtolower($constancia->estudiante->genero);
    $alumn  = ($genero === 'f') ? 'alumna' : 'alumno';
    $adscr  = ($genero === 'f') ? 'adscrita' : 'adscrito';

    // --- Fecha emisión ---
    if (!$constancia->fecha_emision) {
        $constancia->fecha_emision = now();
        $constancia->save();
        $this->agregarHistorial($id, "generado");
    } else {
        $this->agregarHistorial($id, "visualizado");
    }

    // -----------------------
    // Carpetas y rutas
    // -----------------------
    $tempFolder = storage_path('app/temp');
    if (!file_exists($tempFolder)) mkdir($tempFolder, 0777, true);

    $templatePath = storage_path('app/plantillas/constancia.docx');

    $outputDocx = $tempFolder."/constancia_$id.docx";
    $outputPdf  = $tempFolder."/constancia_$id.pdf";

    copy($templatePath, $outputDocx);

    // -----------------------
    // Reemplazos
    // -----------------------
    $reemplazos = [
        '{{nombre}}'        => $constancia->estudiante->nombre . ' ' . $constancia->estudiante->ap . ' ' . $constancia->estudiante->am,
        '{{carrera}}'       => $constancia->estudiante->carrera->nombre,
        '{{no_cuenta}}'     => $constancia->estudiante->no_cuenta,
        '{{empresa}}'       => $constancia->empresa->nombre,
        '{{periodo}}'       => $constancia->periodo->periodo_formateado,
        '{{fecha_emision}}' => \Carbon\Carbon::parse(
                                                        $constancia->fecha_emision ?: now()
                                                    )->translatedFormat('d \d\e F \d\e Y'),
        '{{no_registro}}'   => $constancia->no_registro,
        '{{no_folio}}'      => $constancia->no_folio,
        '{{calificacion}}'  => $constancia->calificacion,
        '{{alumn}}'         => $alumn,
        '{{adscripcion}}'   => $adscr,
    ];

    // -----------------------
    // Archivos donde Word guarda texto (incluye textboxes)
    // -----------------------
    $archivosWord = [
        'word/document.xml',
        'word/header1.xml',
        'word/header2.xml',
        'word/header3.xml',
        'word/footer1.xml',
        'word/footer2.xml',
        'word/footer3.xml',
        'word/textbox.xml',
        'word/textboxes.xml',
        'word/drawings/drawing1.xml',
        'word/drawings/drawing2.xml',
        'word/drawings/drawing3.xml',
        'word/drawings/vmlDrawing1.vml',
        'word/drawings/vmlDrawing2.vml',
        'word/drawings/vmlDrawing3.vml'
    ];

    // -----------------------
    // Edición del DOCX
    // -----------------------
    $zip = new \ZipArchive;
    if ($zip->open($outputDocx) === TRUE) {

        foreach ($archivosWord as $file) {

            if ($zip->locateName($file) === FALSE) continue;

            $xml = $zip->getFromName($file);

            // Normalizar: Word segmenta textos dentro de <w:t>
            $xml = preg_replace('/<w:t[^>]*>/', '', $xml);
            $xml = preg_replace('/<\/w:t>/', '', $xml);

            // Eliminar segmentación de Word dentro de <w:r>
            $xml = preg_replace('/<w:r[^>]*>/', '', $xml);
            $xml = preg_replace('/<\/w:r>/', '', $xml);

            // Quitar saltos invisibles
            $xml = str_replace(["\n", "\r", "\t"], '', $xml);

            // Aplicar cada reemplazo
            foreach ($reemplazos as $marker => $value) {
                $xml = str_replace($marker, htmlspecialchars($value), $xml);
            }

            // Guardar el archivo modificado
            $zip->addFromString($file, $xml);
        }

        $zip->close();
    } else {

        return response()->json([
            'error' => 'No se pudo abrir la plantilla DOCX'
        ]);
    }

    // -----------------------
    // CONVERTIR DOCX → PDF
    // -----------------------
    $soffice = '"C:\Program Files\LibreOffice\program\soffice.exe"';

    $command = $soffice
        .' --headless --convert-to pdf "'.$outputDocx.'" --outdir "'.$tempFolder.'"';

    exec($command . " 2>&1", $logs, $exitCode);

    if (!file_exists($outputPdf)) {
        return response()->json([
            "error"         => "LibreOffice no generó el PDF",
            "comando"       => $command,
            "exit_code"     => $exitCode,
            "logs"          => $logs
        ]);
    }

    // -----------------------
    // Enviar PDF al navegador
    // -----------------------
    return response()->file($outputPdf);
}


    private function convertToPDF($docxPath, $pdfPath)
    {
        $libreOfficePath = '"C:\Program Files\LibreOffice\program\soffice.exe"';
        
        $command = $libreOfficePath . ' --headless --convert-to pdf "' . $docxPath . '" --outdir "' . dirname($pdfPath) . '"';
        
        exec($command, $output, $returnCode);
        
        if ($returnCode !== 0) {
            throw new \Exception('Error al convertir DOCX a PDF');
        }
        
        return true;
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
        $historial = \App\Models\HistorialConstancia::where('id_constancia', $id)
                        ->orderBy('fecha', 'DESC')
                        ->get();

        $constancia = Constancia::with('estudiante')->findOrFail($id);

        return view('constancias.historial', compact('historial', 'constancia'));
    }
}
