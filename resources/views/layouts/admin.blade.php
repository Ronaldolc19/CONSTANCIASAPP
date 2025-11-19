<!doctype html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title','ConstanciasApp')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://kit.fontawesome.com/a2e0e6ad62.js" crossorigin="anonymous"></script>

    <style>
        /* =======================
            THEME VARIABLES
        ========================= */
        :root {
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
            transition: 0.3s ease;
            overflow-y: auto;
            padding-top: 70px;
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
        }

        #sidebar .nav-link:hover {
            background: rgba(255,255,255,0.10);
        }

        #sidebar .nav-link i {
            width: 22px;
            font-size: 18px;
        }

        #sidebar.collapsed .nav-link span {
            display: none;
        }

        #sidebar.collapsed .submenu {
            display: none !important;
        }

        .sb-sidenav-menu-heading {
            font-size: 12px;
            text-transform: uppercase;
            color: #9ea7ad;
            padding: 10px 20px;
            margin-top: 10px;
        }

        /* Submenus */
        .submenu {
            display: none;
            padding-left: 45px;
            flex-direction: column;
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
        }

        /* =======================
            CONTENT
        ========================= */
        #content {
            margin-left: var(--sidebar-width);
            padding: 90px 25px 25px 25px;
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

    </style>
</head>

<body>

    <!-- NAVBAR SUPERIOR -->
    <nav class="navbar navbar-dark bg-dark px-3">
        <button class="btn btn-sm btn-outline-light me-3" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <span class="navbar-brand">ConstanciasApp</span>

        <div class="ms-auto toggle-theme" id="themeToggle">
            <i class="fas fa-moon"></i>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <div id="sidebar">
        <div class="sb-sidenav-menu">

            <div class="sb-sidenav-menu-heading">Gestión</div>

            <!-- CONSTANCIAS -->
            <a class="nav-link" onclick="toggleMenu('m1')">
                <i class="fas fa-file-alt"></i> <span>Constancias</span>
            </a>
            <div id="m1" class="submenu">
                <a class="nav-link" href="{{ route('constancias.index') }}">Listado</a>
                <a class="nav-link" href="{{ route('constancias.create') }}">Nueva</a>
                <a class="nav-link" href="{{ route('constancias.general') }}">Vista General</a>
            </div>

            <!-- ESTUDIANTES -->
            <a class="nav-link" onclick="toggleMenu('m2')">
                <i class="fas fa-user-graduate"></i> <span>Estudiantes</span>
            </a>
            <div id="m2" class="submenu">
                <a class="nav-link" href="{{ route('estudiantes.index') }}">Listado</a>
                <a class="nav-link" href="{{ route('estudiantes.create') }}">Nuevo</a>
            </div>

            <!-- CARRERAS -->
            <a class="nav-link" onclick="toggleMenu('m3')">
                <i class="fas fa-book"></i> <span>Carreras</span>
            </a>
            <div id="m3" class="submenu">
                <a class="nav-link" href="{{ route('carreras.index') }}">Listado</a>
                <a class="nav-link" href="{{ route('carreras.create') }}">Nueva</a>
            </div>

            <!-- EMPRESAS -->
            <a class="nav-link" onclick="toggleMenu('m4')">
                <i class="fas fa-building"></i> <span>Empresas</span>
            </a>
            <div id="m4" class="submenu">
                <a class="nav-link" href="{{ route('empresas.index') }}">Listado</a>
                <a class="nav-link" href="{{ route('empresas.create') }}">Nueva</a>
            </div>

            <!-- PERIODOS -->
            <a class="nav-link" onclick="toggleMenu('m5')">
                <i class="fas fa-calendar-alt"></i> <span>Periodos</span>
            </a>
            <div id="m5" class="submenu">
                <a class="nav-link" href="{{ route('periodos.index') }}">Listado</a>
                <a class="nav-link" href="{{ route('periodos.create') }}">Nuevo</a>
            </div>

        </div>
    </div>

    <!-- CONTENIDO -->
    <div id="content">
        @yield('content')
    </div>

    <script>
        // -------- Toggle Sidebar --------
        document.getElementById("toggleSidebar").addEventListener("click", () => {
            document.getElementById("sidebar").classList.toggle("collapsed");
            document.getElementById("content").classList.toggle("expanded");
        });

        // -------- Submenus --------
        function toggleMenu(id) {
            document.getElementById(id).classList.toggle("show");
        }

        // -------- Dark Mode --------
        const themeToggle = document.getElementById("themeToggle");
        themeToggle.addEventListener("click", () => {
            const html = document.documentElement;
            const current = html.getAttribute("data-theme");
            const newTheme = current === "light" ? "dark" : "light";

            html.setAttribute("data-theme", newTheme);

            themeToggle.innerHTML =
                newTheme === "light"
                    ? `<i class="fas fa-moon"></i>`
                    : `<i class="fas fa-sun"></i>`;
        });

    </script>

</body>
</html>
