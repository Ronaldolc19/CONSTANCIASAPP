<!doctype html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard - Constancias TESVB')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    
    <script src="https://kit.fontawesome.com/a2e0e6ad62.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* =======================
           ESTILOS TESVB Y VARIABLES
        ========================= */
        :root {
            --tesvb-green: #007F3F;
            --tesvb-red: #800020;
            
            --color-bg-light: #f4f5f7;
            --color-bg-dark: #1e1f22;

            --color-sidebar-light: #1a1d20;
            --color-sidebar-dark: #121212;

            --color-text-light: #2d2d2d;
            --color-text-dark: #e0e0e0;

            --sidebar-width: 260px;
            --sidebar-width-collapsed: 80px;
        }

        [data-theme="light"] {
            --bg: var(--color-bg-light);
            --sidebar: var(--color-sidebar-light);
            --text: var(--color-text-light);
        }

        [data-theme="dark"] {
            --bg: var(--color-bg-dark);
            --sidebar: var(--color-sidebar-dark);
            --text: var(--color-text-dark);
        }

        body {
            background: var(--bg);
            color: var(--text);
            margin: 0;
        }

        /* =======================
           SIDEBAR
        ========================= */
        #sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: 0.3s ease;
            overflow-y: auto;
            padding-top: 56px; /* Ajuste para Navbar fixed-top */
            z-index: 1000;
        }

        #sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }

        #sidebar .nav-link {
            color: #cfd8dc !important;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: 0.2s;
            white-space: nowrap;
        }

        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #ffffff !important;
        }
        
        /* Icono principal del enlace */
        #sidebar .nav-link i.fas { 
            width: 22px;
            font-size: 18px;
            margin-right: 10px;
        }

        #sidebar.collapsed .nav-link span,
        #sidebar.collapsed .sb-sidenav-menu-heading {
            display: none;
        }
        
        /* Submenus */
        .submenu {
            display: none;
            padding-left: 50px; 
            flex-direction: column;
            background-color: rgba(0, 0, 0, 0.2);
        }
        
        /* Íconos de submenú */
        .submenu .nav-link i.bi {
            width: 20px;
            font-size: 16px;
            margin-right: 10px;
        }

        .submenu.show {
            display: flex;
        }

        /* =======================
           NAVBAR SUPERIOR
        ========================= */
        nav.navbar {
            width: 100%;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            /* El left=0 se ajustará con el margin-left del content, pero lo dejamos simple por ahora */
        }
        
        /* =======================
           CONTENT
        ========================= */
        #content {
            margin-left: var(--sidebar-width);
            padding: 76px 25px 25px 25px; /* Ajuste de padding-top para el navbar fixed */
            transition: 0.3s ease;
        }

        #content.expanded {
            margin-left: var(--sidebar-width-collapsed);
        }

        /* DARK/LIGHT TOGGLE */
        .toggle-theme {
            cursor: pointer;
            color: white;
            font-size: 22px;
            margin-right: 20px;
        }
        
        /* Estilo para el botón de usuario */
        .navbar .dropdown-toggle::after {
            display: none; /* Oculta la flecha por defecto de Bootstrap */
        }

    </style>
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top px-3">
        
        <button class="btn btn-sm btn-outline-light me-3" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <span class="navbar-brand fw-bold">
            <i class="fas fa-chart-line me-2"></i> Dashboard TESVB
        </span>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                
                {{-- Toggle de Tema --}}
                <li class="nav-item me-3">
                    <a class="nav-link toggle-theme" id="themeToggle" role="button">
                         <i class="fas fa-moon"></i>
                    </a>
                </li>
                
                {{-- Menú de Usuario Logueado --}}
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center" 
                       href="#" id="userDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2 fs-5"></i> 
                        {{ Auth::user()->name }}
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        
                        
                        
                        {{-- Opción de Cerrar Sesión --}}
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                            </a>
                        </li>
                        
                        {{-- Formulario oculto para Logout (POST request) --}}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </nav>


    <div id="sidebar">
        <div class="sb-sidenav-menu">

            <a class="nav-link active" href="{{ url('/dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            

            <a class="nav-link" onclick="toggleMenu('m1')">
                <i class="fas fa-file-alt"></i> <span>Constancias</span>
            </a>
            <div id="m1" class="submenu">
                <a class="nav-link" href="{{ route('constancias.index') }}"><i class="bi bi-list-columns-reverse"></i> Listado</a>
                <a class="nav-link" href="{{ route('constancias.create') }}"><i class="bi bi-plus-circle-fill"></i> Nueva Solicitud</a>
                <a class="nav-link" href="{{ route('constancias.general') }}"><i class="bi bi-bar-chart-line-fill"></i> Vista General</a>
            </div>

            <a class="nav-link" onclick="toggleMenu('m2')">
                <i class="fas fa-user-graduate"></i> <span>Estudiantes</span>
            </a>
            <div id="m2" class="submenu">
                <a class="nav-link" href="{{ route('estudiantes.index') }}"><i class="bi bi-people-fill"></i> Listado</a>
                <a class="nav-link" href="{{ route('estudiantes.create') }}"><i class="bi bi-person-plus-fill"></i> Nuevo</a>
            </div>

            <a class="nav-link" onclick="toggleMenu('m3')">
                <i class="fas fa-book"></i> <span>Carreras</span>
            </a>
            <div id="m3" class="submenu">
                <a class="nav-link" href="{{ route('carreras.index') }}"><i class="bi bi-journals"></i> Listado</a>
                <a class="nav-link" href="{{ route('carreras.create') }}"><i class="bi bi-bookmark-plus-fill"></i> Nueva</a>
            </div>

            <a class="nav-link" onclick="toggleMenu('m4')">
                <i class="fas fa-building"></i> <span>Empresas</span>
            </a>
            <div id="m4" class="submenu">
                <a class="nav-link" href="{{ route('empresas.index') }}"><i class="bi bi-building-fill-gear"></i> Listado</a>
                <a class="nav-link" href="{{ route('empresas.create') }}"><i class="bi bi-buildings-fill"></i> Nueva</a>
            </div>

            <a class="nav-link" onclick="toggleMenu('m5')">
                <i class="fas fa-calendar-alt"></i> <span>Periodos</span>
            </a>
            <div id="m5" class="submenu">
                <a class="nav-link" href="{{ route('periodos.index') }}"><i class="bi bi-calendar-range-fill"></i> Listado</a>
                <a class="nav-link" href="{{ route('periodos.create') }}"><i class="bi bi-calendar-plus-fill"></i> Nuevo</a>
            </div>
            <a class="nav-link" onclick="toggleMenu('m6')">
                <i class="fas fa-user-graduate"></i> <span>Usuarios</span>
            </a>
            <div id="m6" class="submenu">
                <a class="nav-link" href="{{ route('usuarios.index') }}"><i class="bi bi-calendar-range-fill"></i> Listado</a>
            </div>
           

        </div>
    </div>

    <div id="content">
        @yield('content')
    </div>

    <script>
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");
        const themeToggle = document.getElementById("themeToggle");
        const html = document.documentElement;

        // -------- Toggle Sidebar --------
        document.getElementById("toggleSidebar").addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("expanded");
        });

        // -------- Submenus --------
        function toggleMenu(id) {
            document.getElementById(id).classList.toggle("show");
        }

        // -------- Dark Mode --------
        themeToggle.addEventListener("click", () => {
            const current = html.getAttribute("data-theme");
            const newTheme = current === "light" ? "dark" : "light";

            html.setAttribute("data-theme", newTheme);

            // Cambiar icono
            themeToggle.innerHTML =
                newTheme === "light"
                    ? `<i class="fas fa-moon"></i>`
                    : `<i class="fas fa-sun"></i>`;
        });
        
        // Inicializar el icono de tema al cargar
        document.addEventListener('DOMContentLoaded', () => {
            const current = html.getAttribute("data-theme") || 'light';
            themeToggle.innerHTML =
                current === "light"
                    ? `<i class="fas fa-moon"></i>`
                    : `<i class="fas fa-sun"></i>`;
        });
        
    </script>

</body>
</html>