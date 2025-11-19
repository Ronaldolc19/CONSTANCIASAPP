@extends('layouts.admin')

@section('title','Dashboard')

@section('content')

<h3 class="mb-4">Dashboard General</h3>

<div class="row">

    <div class="col-md-3">
        <div class="card shadow-sm p-3 text-center bg-primary text-white">
            <h4>{{ $totalConstancias }}</h4>
            <p>Constancias</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm p-3 text-center bg-success text-white">
            <h4>{{ $totalEstudiantes }}</h4>
            <p>Estudiantes</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm p-3 text-center bg-warning text-white">
            <h4>{{ $totalCarreras }}</h4>
            <p>Carreras</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm p-3 text-center bg-info text-white">
            <h4>{{ $totalEmpresas }}</h4>
            <p>Empresas</p>
        </div>
    </div>

    <div class="col-md-3 mt-3">
        <div class="card shadow-sm p-3 text-center bg-dark text-white">
            <h4>{{ $totalPeriodos }}</h4>
            <p>Periodos</p>
        </div>
    </div>

</div>

@endsection
