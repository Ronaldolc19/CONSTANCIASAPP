<?php

namespace App\Http\Controllers;
use App\Models\Carrera;
use App\Http\Requests\StoreCarreraRequest;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
  public function __construct(){ $this->middleware('auth'); }
    public function index(){ $carreras = Carrera::orderBy('nombre')->paginate(15); return view('carreras.index', compact('carreras')); }
    public function create(){ return view('carreras.create'); }
    public function store(StoreCarreraRequest $request){ Carrera::create($request->validated()); return redirect()->route('carreras.index')->with('success','Carrera creada'); }
    public function show(Carrera $carrera){ return view('carreras.show', compact('carrera')); }
    public function edit(Carrera $carrera){ return view('carreras.edit', compact('carrera')); }
    public function update(StoreCarreraRequest $request, Carrera $carrera){ $carrera->update($request->validated()); return redirect()->route('carreras.index')->with('success','Carrera actualizada'); }
    public function destroy(Carrera $carrera){ $carrera->delete(); return back()->with('success','Carrera eliminada'); }  
}
