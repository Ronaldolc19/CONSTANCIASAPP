<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Generación de Constancias TESVB') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Definición de colores institucionales TESVB */
        .bg-tesvb-green {
            background-color: #007F3F !important; /* Verde Oscuro */
        }
        .text-tesvb-red {
            color: #800020 !important; /* Guinda/Tinto */
        }
        .border-tesvb-green {
            border-color: #007F3F !important;
        }
        .btn-tesvb-primary {
            color: #fff;
            background-color: #F5821F; /* Naranja para el botón principal */
            border-color: #F5821F;
        }
        .btn-tesvb-primary:hover {
            background-color: #e06d0a;
            border-color: #e06d0a;
        }
        /* Estilo para la sección de cabecera (Hero Section) */
        .hero-section {
            background: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.2)), url('{{ asset('images/edificio_tesvb.png') }}') no-repeat center center;
            background-size: cover;
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-section h1 {
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
        }
    </style>
</head>
<body>
    <div id="app">
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-tesvb-green shadow-lg">
            <div class="container">
                
                {{-- Se elimina la referencia a 'Laravel' y se usa el nombre institucional --}}
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo_tesvb.png') }}" alt="Logo TESVB" style="height: 50px; margin-right: 10px;">
                    <strong class="h4 mb-0">Generación de Constancias TESVB</strong>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav me-auto">
                        {{-- Espacio para futuros enlaces como 'Acerca de' o 'Instrucciones' --}}
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-light me-2" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Iniciar Sesión') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            {{-- Bloque para usuarios AUTENTICADOS (Dropdown de Usuario) --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" 
                                   href="#" role="button" 
                                   data-bs-toggle="dropdown" {{-- CLAVE para que funcione el dropdown --}}
                                   aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    
                                    {{-- Enlace al Dashboard --}}
                                    <a class="dropdown-item" href="{{ url('/dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                    </a>
                                    
                                    <div class="dropdown-divider"></div>
                                    
                                    {{-- Enlace de CERRAR SESIÓN (Logout) --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Lógica para mostrar el HERO solo en la ruta principal (asumiendo que '/' o 'welcome' es la home) --}}
        @if (Request::is('/') || Route::currentRouteName() == 'welcome')
        
            <div class="hero-section">
                <div class="container text-white">
                    <h1 class="display-3 text-tesvb-red">
                        Sistema de Constancias de Servicio Social
                    </h1>
                    <p class="lead mb-4 text-tesvb-red">
                        Tecnológico de Estudios Superiores de Valle de Bravo
                    </p>
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-tesvb-primary btn-lg shadow-sm">
                        Acceder al Sistema <i class="bi bi-box-arrow-in-right"></i>
                    </a>
                    @endguest
                </div>
            </div>

            <main class="py-5 bg-light">
                
            </main>
            
        @else
        
        <main class="py-4">
            @yield('content')
        </main>
        
        @endif
        
        <footer class="bg-tesvb-green text-white pt-4 pb-2 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="text-white">Contacto Institucional</h5>
                        <p class="mb-1">Tecnológico de Estudios Superiores de Valle de Bravo.</p>
                        <p class="mb-1">Dirección: Av. Tecnológico S/N, Ejido de San Juan, Valle de Bravo, México.</p>
                        <p>Email: contacto@tesvb.edomex.gob.mx</p>
                    </div>
                    <div class="col-md-6 mb-3 text-md-end">
                        {{-- Asume que las imágenes ya tienen estos nombres --}}
                        <img src="{{ asset('images/logo_tesvb.png') }}" alt="Logo TESVB Footer" style="height: 40px; opacity: 0.8;">
                        <img src="{{ asset('images/logo_hurones.png') }}" alt="Hurones Logo" style="height: 50px; margin-left: 15px;">
                    </div>
                </div>
                <hr class="bg-light">
                <p class="text-center text-muted small mb-0">
                    &copy; {{ date('Y') }} TESVB. Todos los derechos reservados.
                </p>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>
</html>