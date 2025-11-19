<?php

namespace App\Http\Controllers;
use App\Models\Estudiante;
use App\Models\Carrera;
use App\Http\Requests\StoreEstudianteRequest;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }
    public function index(){ $estudiantes = Estudiante::with('carrera')->orderBy('nombre')->paginate(20); return view('estudiantes.index', compact('estudiantes')); }
    public function create(){ $carreras = Carrera::orderBy('nombre')->get(); return view('estudiantes.create', compact('carreras')); }
    public function store(StoreEstudianteRequest $request){ Estudiante::create($request->validated()); return redirect()->route('estudiantes.index')->with('success','Estudiante creado'); }
    public function show(Estudiante $estudiante){ return view('estudiantes.show', compact('estudiante')); }
    public function edit(Estudiante $estudiante){ $carreras = Carrera::orderBy('nombre')->get(); return view('estudiantes.edit', compact('estudiante','carreras')); }
    public function update(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ap' => 'required|string|max:255',
            'am' => 'required|string|max:255',
            'genero' => 'required|string|max:10',
            'no_cuenta' => 'required|string|max:50|unique:estudiantes,no_cuenta,' . $estudiante->id_estudiante . ',id_estudiante',
            'id_carrera' => 'required|integer|exists:carreras,id_carrera',
        ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')
                        ->with('success','Estudiante actualizado correctamente');
    }
    public function destroy(Estudiante $estudiante){ $estudiante->delete(); return back()->with('success','Estudiante eliminado'); }
}
