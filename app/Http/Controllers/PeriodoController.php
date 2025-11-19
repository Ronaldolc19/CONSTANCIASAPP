<?php

namespace App\Http\Controllers;
use App\Models\Periodo;
use Illuminate\Http\Request;
use App\Http\Requests\StorePeriodoRequest;

class PeriodoController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }
    public function index(){ $periodos = Periodo::orderBy('fecha_inicio','desc')->paginate(15); return view('periodos.index', compact('periodos')); }
    public function create(){ return view('periodos.create'); }
    public function store(StorePeriodoRequest $request){ Periodo::create($request->validated()); return redirect()->route('periodos.index')->with('success','Periodo creado'); }
    public function show(Periodo $periodo){ return view('periodos.show', compact('periodo')); }
    public function edit(Periodo $periodo){ return view('periodos.edit', compact('periodo')); }
    public function update(StorePeriodoRequest $request, Periodo $periodo){ $periodo->update($request->validated()); return redirect()->route('periodos.index')->with('success','Periodo actualizado'); }
    public function destroy(Periodo $periodo){ $periodo->delete(); return back()->with('success','Periodo eliminado'); }
}
