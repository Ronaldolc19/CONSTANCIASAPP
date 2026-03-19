<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema de Constancias TESVB') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --tesvb-green: #007F3F;
            --tesvb-gold: #F5821F;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-tesvb {
            background-color: var(--tesvb-green);
            padding: 0.8rem 0;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('{{ asset('images/edificio_tesvb.png') }}') no-repeat center center;
            background-size: cover;
            min-height: 65vh;
            display: flex;
            align-items: center;
            color: white;
        }

        .btn-tesvb-gold {
            background-color: var(--tesvb-gold);
            border: none;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-tesvb-gold:hover {
            background-color: #e06d0a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 130, 31, 0.4);
        }

        /* Footer Simplificado */
        footer {
            background-color: #f1f5f9;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-tesvb shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo_tesvb.png') }}" alt="Logo" style="height: 40px; margin-right: 12px;">
                    <div class="d-flex flex-column">
                        <span class="fw-bold lh-1 h5 mb-0 text-uppercase">TESVB</span>
                        <small style="font-size: 0.7rem; opacity: 0.8;">Control de Constancias</small>
                    </div>
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link fw-semibold px-3 text-white" href="{{ route('login') }}">
                                        {{ __('Iniciar Sesión') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center bg-white bg-opacity-10 rounded-pill px-3 text-white" 
                                   href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-2"></i> {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ url('/dashboard') }}">
                                            <i class="bi bi-grid-fill me-2 text-success"></i> Panel Principal
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i> {{ __('Cerrar Sesión') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if (Request::is('/') || Request::is('welcome'))
            <header class="hero-section">
                <div class="container text-center">
                    <h1 class="display-4 fw-bold mb-3">Liberación de Servicio Social</h1>
                    <p class="fs-5 mb-5 opacity-90 fw-light">Sistema Local de Gestión de Constancias Administrativas</p>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-tesvb-gold btn-lg shadow">
                            Acceder al Sistema <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </a>
                    @endguest
                </div>
            </header>
        @else
            <main class="py-5">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        @endif
    </div>

    <footer class="py-3 mt-auto">
        <div class="container text-center">
            <p class="small mb-0">
                &copy; {{ date('Y') }} TESVB. Todos los derechos reservados.
            </p>
        </div>
    </footer>

    {{-- Script Único --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>