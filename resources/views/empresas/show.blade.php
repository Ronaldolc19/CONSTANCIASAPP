@extends('layouts.app')
@section('title', 'Detalles de Empresa')
@section('content')
<h2>Detalles de Empresa</h2>
<ul class="list-group">
    <li class="list-group-item"><strong>ID:</strong> {{ $empresa->id_empresa }}</li>
    <li class="list-group-item"><strong>Nombre:</strong> {{ $empresa->nombre }}</li>
</ul>
<a href="{{ route('empresas.index') }}" class="btn btn-primary mt-3">Volver</a>
@endsection
