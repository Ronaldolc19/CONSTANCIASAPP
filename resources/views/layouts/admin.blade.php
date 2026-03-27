<!doctype html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TESVB - Sistema de Gestión')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    
    <script src="https://kit.fontawesome.com/a2e0e6ad62.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --tesvb-green: #007F3F;
            --tesvb-gold: #D4AF37;
            --sidebar-bg: #0f172a;
            --sidebar-hover: rgba(255, 255, 255, 0.08);
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 88px;
            --glass-effect: blur(12px) saturate(180%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fe;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* --- SIDEBAR MASTER --- */
        #sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1060;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: #fff;
            display: flex;
            flex-direction: column;
            box-shadow: 10px 0 30px rgba(0,0,0,0.1);
        }

        #sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* --- LOGO AREA --- */
        .sidebar-brand {
            height: 80px;
            display: flex;
            align-items: center;
            padding: 0 25px;
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            overflow: hidden;
        }

        .brand-logo {
            min-width: 40px;
            height: 40px;
            background: var(--tesvb-green);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 15px;
            box-shadow: 0 4px 12px rgba(0, 127, 63, 0.4);
        }

        /* --- NAVIGATION --- */
        .sidebar-scroll {
            flex-grow: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 20px 0;
        }

        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

        .nav-header {
            padding: 15px 30px 10px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
        }

        .nav-item {
            position: relative;
            margin: 4px 15px;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 14px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .nav-link-custom i:first-child {
            font-size: 1.25rem;
            margin-right: 15px;
            min-width: 25px;
            transition: transform 0.3s ease;
        }

        .nav-link-custom:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .nav-link-custom.active {
            background: rgba(0, 127, 63, 0.15);
            color: var(--tesvb-green);
            font-weight: 600;
        }

        .nav-link-custom.active::before {
            content: '';
            position: absolute;
            left: -15px;
            top: 15%;
            height: 70%;
            width: 5px;
            background: var(--tesvb-green);
            border-radius: 0 5px 5px 0;
            box-shadow: 2px 0 10px rgba(0, 127, 63, 0.5);
        }

        /* --- SUBMENUS --- */
        .submenu-wrapper {
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s ease;
            padding-left: 25px;
        }

        .submenu-wrapper.show {
            max-height: 500px;
            margin-top: 5px;
        }

        .sub-link {
            display: flex;
            align-items: center;
            padding: 8px 18px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .sub-link:hover { color: #fff; }
        .sub-link::before {
            content: "•";
            margin-right: 10px;
            opacity: 0.5;
        }

        /* --- MAIN CONTENT AREA --- */
        #content-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #content-wrapper.expanded { margin-left: var(--sidebar-collapsed-width); }

        .top-navbar {
            height: 80px;
            background: rgba(244, 247, 254, 0.8) !important;
            backdrop-filter: var(--glass-effect);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 0 40px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .main-container {
            padding: 30px 40px;
            flex-grow: 1;
        }

        /* --- COLLAPSE LOGIC --- */
        #sidebar.collapsed .nav-text, 
        #sidebar.collapsed .nav-header,
        #sidebar.collapsed .chevron-icon,
        #sidebar.collapsed .brand-name {
            display: none;
        }

        /* --- BUTTONS & UTILS --- */
        .btn-toggle {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            color: var(--sidebar-bg);
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-toggle:hover { background: var(--tesvb-green); color: #fff; }

        .user-pill {
            background: #fff;
            padding: 6px 15px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            border: 1px solid rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

    <aside id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <span class="brand-name fw-bold fs-5 mb-0">TESVB <span class="text-success">Servicio Social</span></span>
        </div>

        <div class="sidebar-scroll">
            <div class="nav-header">Principal</div>
            
            <div class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link-custom {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span class="nav-text">Panel Control</span>
                </a>
            </div>

            <div class="nav-header">Gestión Escolar</div>

            <div class="nav-item">
                <a href="javascript:void(0)" class="nav-link-custom" onclick="toggleSubmenu('sub-constancias')">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span class="nav-text">Constancias</span>
                    <i class="bi bi-chevron-down ms-auto chevron-icon fs-xs"></i>
                </a>
                <div id="sub-constancias" class="submenu-wrapper">
                    
                    <a href="{{ route('constancias.general') }}" class="sub-link">Panel General</a>
                </div>
            </div>

            <div class="nav-item">
                <a href="javascript:void(0)" class="nav-link-custom" onclick="toggleSubmenu('sub-estudiantes')">
                    <i class="bi bi-people-fill"></i>
                    <span class="nav-text">Estudiantes</span>
                    <i class="bi bi-chevron-down ms-auto chevron-icon fs-xs"></i>
                </a>
                <div id="sub-estudiantes" class="submenu-wrapper">
                    <a href="{{ route('estudiantes.index') }}" class="sub-link">Ver Alumnos</a>
                    <a href="{{ route('estudiantes.create') }}" class="sub-link">Registrar Nuevo</a>
                </div>
            </div>

            <div class="nav-header">Configuración</div>

            <div class="nav-item">
                <a href="{{ route('carreras.index') }}" class="nav-link-custom {{ request()->is('carreras*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span class="nav-text">Carreras</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('empresas.index') }}" class="nav-link-custom {{ request()->is('empresas*') ? 'active' : '' }}">
                    <i class="bi bi-building-fill"></i>
                    <span class="nav-text">Empresas</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('periodos.index') }}" class="nav-link-custom {{ request()->is('periodos*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event-fill"></i>
                    <span class="nav-text">Periodos</span>
                </a>
            </div>
        </div>
    </aside>

    <main id="content-wrapper">
        <header class="top-navbar">
            <button class="btn-toggle me-4" id="btn-collapse">
                <i class="fas fa-bars-staggered"></i>
            </button>

            <h5 class="mb-0 fw-bold d-none d-md-block">@yield('title')</h5>

            <div class="ms-auto d-flex align-items-center">
                @auth
                <div class="dropdown">
                    <div class="user-pill dropdown-toggle cursor-pointer" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=007F3F&color=fff" 
                             class="rounded-circle me-2" width="30" height="30">
                        <span class="small fw-semibold d-none d-sm-inline">{{ Auth::user()->name }}</span>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-2">
                        <li><a class="dropdown-item rounded-3" href="#"><i class="bi bi-person me-2"></i> Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item rounded-3 text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </header>

        <section class="main-container">
            @yield('content')
        </section>
    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const wrapper = document.getElementById('content-wrapper');
        const btnCollapse = document.getElementById('btn-collapse');

        // Toggle Sidebar
        btnCollapse.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            wrapper.classList.toggle('expanded');
        });

        // Toggle Submenus
        function toggleSubmenu(id) {
            const menu = document.getElementById(id);
            const allMenus = document.querySelectorAll('.submenu-wrapper');
            
            allMenus.forEach(m => {
                if(m.id !== id) m.classList.remove('show');
            });

            menu.classList.toggle('show');
            
            // Si el sidebar está colapsado, lo expandimos al abrir un submenu
            if(sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                wrapper.classList.remove('expanded');
            }
        }

        // Auto-activar submenús si la ruta coincide
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const sublinks = document.querySelectorAll('.sub-link');
            sublinks.forEach(link => {
                if(currentPath.includes(link.getAttribute('href'))) {
                    link.closest('.submenu-wrapper').classList.add('show');
                    link.style.color = '#fff';
                    link.style.fontWeight = 'bold';
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>