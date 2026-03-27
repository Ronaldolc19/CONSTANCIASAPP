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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConstanciasExport;

class ConstanciaController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        // Cargamos la constancia con su estudiante y las relaciones que ahora cuelgan del estudiante
        $constancias = Constancia::with(['estudiante.carrera', 'estudiante.empresa', 'estudiante.periodo'])
            ->orderBy('id_constancia', 'DESC')
            ->get();

        return view('constancias.index', compact('constancias'));
    }

    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre')->get();
        $empresas = Empresa::orderBy('nombre')->get();
        $periodos = Periodo::orderBy('fecha_inicio')->get();

        return view('constancias.create', compact('estudiantes', 'empresas', 'periodos'));
    }

    public function store(Request $request)
    {
        // La validación de unique ahora debe apuntar a la tabla estudiantes
        $request->validate([
            'id_estudiante' => 'required|exists:estudiantes,id_estudiante',
            'id_empresa' => 'required',
            'id_periodo' => 'required',
            'no_registro' => 'required|unique:estudiantes,no_registro',
            'no_folio' => 'required|unique:estudiantes,no_folio',
            'calificacion' => 'required',
            'fecha_emision' => 'nullable|date',
        ]);

        // 1. Actualizamos los datos técnicos en el modelo Estudiante
        $estudiante = Estudiante::findOrFail($request->id_estudiante);
        $estudiante->update([
            'id_empresa' => $request->id_empresa,
            'id_periodo' => $request->id_periodo,
            'no_registro' => $request->no_registro,
            'no_folio' => $request->no_folio,
            'calificacion' => $request->calificacion,
            'fecha_emision' => $request->fecha_emision ?: Carbon::now()->format('Y-m-d')
        ]);

        // 2. Creamos el registro en la tabla constancias (que solo lleva estado y FK)
        Constancia::create([
            'id_estudiante' => $request->id_estudiante,
            'estado' => 'pendiente', 
            'pdf_path' => null
        ]);

        return redirect()->route('constancias.index')->with('success', 'Constancia registrada y datos de estudiante actualizados.');
    }

    public function edit($id)
    {
        // 1. Obtener la constancia con sus relaciones
        $constancia = Constancia::with('estudiante.empresa', 'estudiante.periodo')->findOrFail($id);

        // 2. Obtener TODAS las opciones para los selectores
        $carreras = Carrera::all(); 
        $periodos = Periodo::all();
        $empresas = Empresa::all();

        // 3. Pasar TODO a la vista
        return view('constancias.edit', compact('constancia', 'carreras', 'periodos', 'empresas'));
    }

    public function update(Request $request, $id)
    {
        $constancia = Constancia::findOrFail($id);
        $estudiante = Estudiante::findOrFail($constancia->id_estudiante);

        $request->validate([
            'nombre'        => 'required|string|max:255',
            'ap'            => 'required|string|max:255',
            'no_cuenta'     => 'required|unique:estudiantes,no_cuenta,' . $estudiante->id_estudiante . ',id_estudiante',
            'id_carrera'    => 'required|exists:carreras,id_carrera',
            'id_empresa'    => 'required|exists:empresas,id_empresa',
            'id_periodo'    => 'required|exists:periodos,id_periodo',
            'calificacion'  => 'required|numeric',
            'no_registro'   => 'required|unique:estudiantes,no_registro,' . $estudiante->id_estudiante . ',id_estudiante',
            'no_folio'      => 'required|unique:estudiantes,no_folio,' . $estudiante->id_estudiante . ',id_estudiante',
        ]);

        // Actualización masiva de todos los campos del estudiante
        $estudiante->update($request->only([
            'nombre', 'ap', 'am', 'genero', 'no_cuenta', 
            'id_carrera', 'id_empresa', 'id_periodo', 
            'calificacion', 'no_registro', 'no_folio', 'fecha_emision'
        ]));

        // Sincronizamos la constancia (podrías forzar el estado a 'emitida' aquí si quisieras)
        $constancia->touch(); 

        return redirect()->route('constancias.general')->with('success', 'Expediente actualizado integralmente.');
    }

    public function show($id)
    {
        // Cargamos con las relaciones anidadas para la vista que creamos
        $constancia = Constancia::with(['estudiante.carrera', 'estudiante.empresa', 'estudiante.periodo'])
            ->findOrFail($id);

        return view('constancias.show', compact('constancia'));
    }

    public function destroy($id)
    {
        Constancia::findOrFail($id)->delete();
        return redirect()->route('constancias.index')->with('success', 'Constancia eliminada.');
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
        // 1. Iniciamos la consulta con la carga ambiciosa (Eager Loading) anidada
        $query = Constancia::with(['estudiante.carrera', 'estudiante.empresa', 'estudiante.periodo']);

        // Filtro: Búsqueda por Nombre, Apellido o Número de Cuenta (En Estudiante)
        if ($request->filled('search')) {
            $query->whereHas('estudiante', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%')
                ->orWhere('ap', 'like', '%' . $request->search . '%')
                ->orWhere('no_cuenta', 'like', '%' . $request->search . '%');
            });
        }

        // Filtro: Carrera (En Estudiante)
        if ($request->filled('id_carrera')) {
            $query->whereHas('estudiante', function($q) use ($request) {
                $q->where('id_carrera', $request->id_carrera);
            });
        }

        // Filtro: Empresa (AHORA en Estudiante)
        if ($request->filled('id_empresa')) {
            $query->whereHas('estudiante', function($q) use ($request) {
                $q->where('id_empresa', $request->id_empresa);
            });
        }

        // Filtro: Periodo (AHORA en Estudiante)
        if ($request->filled('id_periodo')) {
            $query->whereHas('estudiante', function($q) use ($request) {
                $q->where('id_periodo', $request->id_periodo);
            });
        }

        // Filtro: Estado (Este SI sigue en la tabla Constancias)
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // 2. Ejecutar consulta
        $constancias = $query->latest()->paginate(10);

        // 3. Cargar catálogos para los select de los filtros en la vista
        $carreras = \App\Models\Carrera::orderBy('nombre')->get();
        $periodos = \App\Models\Periodo::orderBy('fecha_inicio', 'DESC')->get();
        $empresas = \App\Models\Empresa::orderBy('nombre')->get();

        // 4. Retornar vista con los datos compactados
        return view('constancias.general', compact('constancias', 'carreras', 'periodos', 'empresas'));
    }
    
public function generarDOCX($id)
{
    try {
        $constancia = Constancia::with(['estudiante.carrera', 'estudiante.empresa', 'estudiante.periodo'])->findOrFail($id);
        $estudiante = $constancia->estudiante;

        // VERIFICACIÓN DE PLANTILLA
        $templatePath = public_path('plantilla/CONSTANCIAUP.docx');
        if (!file_exists($templatePath)) {
            return "Error: No existe la plantilla en $templatePath";
        }

        // DEFINICIÓN DE RUTAS
        $nombreCarpetaPeriodo = \Illuminate\Support\Str::slug($estudiante->periodo->periodo_formateado ?? 'sin-periodo');
        $relDir = "pdf/periodos/{$nombreCarpetaPeriodo}";
        $pdfDir = storage_path("app/public/{$relDir}");

        if (!file_exists($pdfDir)) {
            mkdir($pdfDir, 0777, true); 
        }

        // NOMBRES DE ARCHIVO
        $nombreEstudianteSlug = \Illuminate\Support\Str::slug($estudiante->nombre . ' ' . $estudiante->ap);
        $nombreArchivoFinal = "{$estudiante->no_cuenta}_{$nombreEstudianteSlug}.pdf";
        $pdfPathFinal = "{$pdfDir}/{$nombreArchivoFinal}";

        // --- PROCESO DE WORD ---
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) mkdir($tempDir, 0777, true);
        $tempFile = "{$tempDir}/temp_constancia_{$id}.docx";
        copy($templatePath, $tempFile);

        // Lógica de Género
        $esFemenino = (strtolower($estudiante->genero) === 'f');

        // FORMATEO DE FECHA PERSONALIZADO: "los 04 días del mes de julio de 2025"
        $fechaCarbon = \Carbon\Carbon::parse($estudiante->fecha_emision ?? now())->locale('es');
        $dia = $fechaCarbon->format('d'); // Mantiene el cero inicial (04)
        $mes = $fechaCarbon->translatedFormat('F'); // Nombre del mes completo
        $anio = $fechaCarbon->format('Y');
        $fechaFormateadaParaDoc = "a los {$dia} días del mes de {$mes} de {$anio}";

        $variables = [
            '{{NOMBRE}}'        => mb_strtoupper($estudiante->nombre . ' ' . $estudiante->ap . ' ' . $estudiante->am, 'UTF-8'),
            '{{ALU}}'           => $esFemenino ? 'Alumna' : 'Alumno',
            '{{ADSCR}}'         => $esFemenino ? 'adscrita' : 'adscrito',
            // Cambiado: Ya no usa mb_strtoupper para respetar la escritura original
            '{{CARRERA}}'       => $estudiante->carrera->nombre ?? '',
            '{{NO_CUENTA}}'     => $estudiante->no_cuenta,
            // Cambiado: Ya no usa mb_strtoupper para respetar la escritura original
            '{{EMPRESA}}'       => $estudiante->empresa->nombre ?? '',
            '{{PERIODO}}'       => $estudiante->periodo->periodo_formateado ?? '',
            '{{FECHA_EMISION}}' => $fechaFormateadaParaDoc,
            '{{NO_REGISTRO}}'   => $estudiante->no_registro,
        ];

        $zip = new \ZipArchive;
        if ($zip->open($tempFile) === TRUE) {
            $xml = $zip->getFromName('word/document.xml');
            
            foreach ($variables as $key => $value) {
                // htmlspecialchars con ENT_QUOTES para evitar que Word rompa el estilo de la fuente
                $cleanValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                $xml = str_replace($key, $cleanValue, $xml);
            }
            
            $zip->addFromString('word/document.xml', $xml);
            $zip->close();
        }

        // --- CONVERSIÓN ---
        $soffice = PHP_OS_FAMILY === 'Windows' 
            ? '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"' 
            : '/usr/bin/libreoffice';

        $command = "$soffice --headless --convert-to pdf \"$tempFile\" --outdir \"$pdfDir\" 2>&1";
        exec($command, $output, $exitCode);

        $pdfGeneradoPorLibreOffice = "{$pdfDir}/temp_constancia_{$id}.pdf";

        if (!file_exists($pdfGeneradoPorLibreOffice)) {
            return "Error de LibreOffice: No se generó el PDF. Logs: " . implode("\n", $output);
        }

        if (file_exists($pdfPathFinal)) unlink($pdfPathFinal);
        rename($pdfGeneradoPorLibreOffice, $pdfPathFinal);
        if (file_exists($tempFile)) unlink($tempFile);

        $constancia->update([
            'pdf_path' => "{$relDir}/{$nombreArchivoFinal}",
            'estado' => 'emitida'
        ]);

        return redirect()->back()->with('success', 'PDF generado con éxito.');

    } catch (\Exception $e) {
        return "Error crítico: " . $e->getMessage();
    }
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
        // Simplemente cargamos las relaciones. 
        // Laravel usará el orderBy('fecha', 'desc') que ya definiste en el modelo.
        $constancia = Constancia::with([
            'estudiante.carrera', 
            'estudiante.empresa', 
            'estudiante.periodo',
            'historial.usuario' // Quitamos la función anónima para evitar conflictos
        ])->findOrFail($id);

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

    if (!$constancia->pdf_path) {
        return back()->with('error', 'El PDF no existe.');
    }

    $pdfPath = storage_path("app/public/{$constancia->pdf_path}");

    if (!file_exists($pdfPath)) {
        return back()->with('error', 'Archivo físico no encontrado.');
    }

    $constancia->update(['estado' => 'emitida']);
    $this->agregarHistorial($id, "descargado");

    return response()->download($pdfPath);
}


}
