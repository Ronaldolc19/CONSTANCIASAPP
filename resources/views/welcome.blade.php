@extends('layouts.app')

{{-- 
    La variable $is_home_page se usa en el layout/app.blade.php para 
    mostrar la sección HERO (edificio) solo en la página principal.
--}}

@section('content')
    {{-- 
        Este bloque se deja vacío (o con contenido simple si lo deseas) 
        porque el diseño HERO ya está en la plantilla maestra (app.blade.php) 
        cuando detecta que es la ruta principal. 
    --}}
    <div class="container text-center py-5">
        {{-- Puedes agregar un mensaje o componente adicional aquí si lo necesitas --}}
        {{-- <p class="lead">Haga clic en 'Iniciar Sesión' para acceder al sistema.</p> --}}
    </div>
@endsection