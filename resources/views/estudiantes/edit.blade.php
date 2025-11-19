@extends('layouts.app')
@section('title','Editar Estudiante')
@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <h2>Editar Estudiante</h2>

    <form action="{{ route('estudiantes.update', $estudiante->id_estudiante) }}" method="POST">
      @csrf @method('PUT')

      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $estudiante->nombre) }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Apellido Paterno</label>
        <input type="text" name="ap" class="form-control" value="{{ old('ap', $estudiante->ap) }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Apellido Materno</label>
        <input type="text" name="am" class="form-control" value="{{ old('am', $estudiante->am) }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Género</label>
        <select name="genero" class="form-select">
          <option value="">-- seleccionar --</option>
          <option value="M" {{ old('genero', $estudiante->genero) == 'M' ? 'selected' : '' }}>Masculino</option>
          <option value="F" {{ old('genero', $estudiante->genero) == 'F' ? 'selected' : '' }}>Femenino</option>
          <option value="O" {{ old('genero', $estudiante->genero) == 'O' ? 'selected' : '' }}>Otro</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">No. de cuenta</label>
        <input type="text" name="no_cuenta" class="form-control" value="{{ old('no_cuenta', $estudiante->no_cuenta) }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Carrera</label>
        <select name="id_carrera" class="form-select" required>
          <option value="">-- seleccionar carrera --</option>
          @foreach($carreras as $c)
            <option value="{{ $c->id_carrera }}" {{ (old('id_carrera', $estudiante->id_carrera) == $c->id_carrera) ? 'selected' : '' }}>
              {{ $c->nombre }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-success">Actualizar</button>
        <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>
@endsection
