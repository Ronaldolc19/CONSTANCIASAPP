<?php

namespace App\Http\Controllers;
use App\Models\Estudiante;
use App\Models\Carrera;
use App\Models\Empresa;
use App\Models\Periodo;
use App\Models\Constancia;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreEstudianteRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class EstudianteController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }
    public function index(Request $request) // Línea 21 corregida
{
    $query = Estudiante::with(['carrera', 'empresa']);

    // Filtro por Buscador (Nombre, Apellido o No. Cuenta)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nombre', 'LIKE', "%{$search}%")
              ->orWhere('ap', 'LIKE', "%{$search}%")
              ->orWhere('no_cuenta', 'LIKE', "%{$search}%");
        });
    }

    // Filtro por Carrera
    if ($request->filled('id_carrera')) {
        $query->where('id_carrera', $request->id_carrera);
    }

    // Filtro por Empresa
    if ($request->filled('id_empresa')) {
        $query->where('id_empresa', $request->id_empresa);
    }

    // Paginamos y obtenemos el resto de datos
    $estudiantes = $query->latest()->paginate(15);
    $carreras = Carrera::all();
    $empresas = Empresa::all();

    return view('estudiantes.index', compact('estudiantes', 'carreras', 'empresas'));
}

    public function create()
    {
        $carreras = Carrera::all();
        $empresas = Empresa::all();
        $periodos = Periodo::all();
        return view('estudiantes.create', compact('carreras', 'empresas', 'periodos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'ap'            => 'required|string|max:255',
            'am'            => 'required|string|max:255',
            'genero'        => 'required|string',
            'no_cuenta'     => 'required|string|unique:estudiantes,no_cuenta',
            'id_carrera'    => 'required|exists:carreras,id_carrera',
            'id_empresa'    => 'required|exists:empresas,id_empresa',
            'id_periodo'    => 'required|exists:periodos,id_periodo',
            // Validación de unicidad para los nuevos campos
            'no_registro'   => 'nullable|string|unique:estudiantes,no_registro',
            'no_folio'      => 'nullable|string|unique:estudiantes,no_folio',
            'calificacion'  => 'nullable|string',
            'fecha_emision' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            $estudiante = Estudiante::create($request->all());

            Constancia::create([
                'id_estudiante' => $estudiante->id_estudiante,
                'estado'        => 'pendiente',
                'archivado'     => false,
            ]);

            DB::commit();
            return redirect()->route('estudiantes.index')->with('success', 'Expediente creado con éxito.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $estudiante = Estudiante::with(['carrera', 'empresa', 'periodo', 'constancias'])->findOrFail($id);
        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $carreras = Carrera::all();
        $empresas = Empresa::all();
        $periodos = Periodo::all();
        return view('estudiantes.edit', compact('estudiante', 'carreras', 'empresas', 'periodos'));
    }

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $request->validate([
            // Validamos unicidad ignorando el ID actual para permitir la edición sin conflictos
            'no_cuenta'    => ['required', Rule::unique('estudiantes')->ignore($id, 'id_estudiante')],
            'no_registro'  => ['nullable', Rule::unique('estudiantes')->ignore($id, 'id_estudiante')],
            'no_folio'     => ['nullable', Rule::unique('estudiantes')->ignore($id, 'id_estudiante')],
            'id_carrera'   => 'required',
            'id_empresa'   => 'required',
            'id_periodo'   => 'required',
        ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')->with('info', 'Expediente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();
        return redirect()->route('estudiantes.index')->with('warning', 'Registro eliminado.');
    }
    public function generarNumeros()
    {
        // Ahora invocamos los métodos desde el modelo Estudiante
        return response()->json([
            'no_registro' => \App\Models\Estudiante::generarNumeroRegistro(),
            'no_folio'    => \App\Models\Estudiante::generarNumeroFolio()
        ]);
    }
}
