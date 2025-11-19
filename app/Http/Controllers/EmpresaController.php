<?php

namespace App\Http\Controllers;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmpresaRequest;

class EmpresaController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }
    public function index(){ $empresas = Empresa::orderBy('nombre')->paginate(15); return view('empresas.index', compact('empresas')); }
    public function create(){ return view('empresas.create'); }
    public function store(StoreEmpresaRequest $request){ Empresa::create($request->validated()); return redirect()->route('empresas.index')->with('success','Empresa creada'); }
    public function show(Empresa $empresa){ return view('empresas.show', compact('empresa')); }
    public function edit(Empresa $empresa){ return view('empresas.edit', compact('empresa')); }
    public function update(StoreEmpresaRequest $request, Empresa $empresa){ $empresa->update($request->validated()); return redirect()->route('empresas.index')->with('success','Empresa actualizada'); }
    public function destroy(Empresa $empresa){ $empresa->delete(); return back()->with('success','Empresa eliminada'); }
}
