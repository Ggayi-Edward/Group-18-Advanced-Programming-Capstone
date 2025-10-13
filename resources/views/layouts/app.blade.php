<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Projects Management System')</title>

    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AdminLTE + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        /* Navbar */
        .main-header {
            background: linear-gradient(90deg, #2c3e50, #34495e);
            border-bottom: none;
        }
        .main-header .nav-link {
            color: #ecf0f1 !important;
            font-weight: 500;
            transition: color 0.2s ease-in-out;
        }
        .main-header .nav-link:hover {
            color: #1abc9c !important;
        }

        /* Sidebar */
        .main-sidebar {
            background: linear-gradient(180deg, #1e2936 0%, #243440 100%) !important;
        }
        .brand-link {
            font-weight: 600;
            font-size: 1.2rem;
            padding: 1rem;
            background: rgba(0,0,0,0.15);
        }
        .brand-link .brand-image {
            font-size: 1.5rem;
        }

        /* Sidebar menu */
        .nav-sidebar .nav-item .nav-link {
            border-radius: .4rem;
            margin: .15rem .5rem;
            color: #bdc3c7;
            transition: all 0.2s ease-in-out;
        }
        .nav-sidebar .nav-item .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .nav-sidebar .nav-item .nav-link.active {
            background: linear-gradient(135deg, #2980b9, #3498db);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        }

        /* Sidebar icons */
        .nav-sidebar .nav-link i {
            width: 20px;
        }
    </style>
    @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand">
        <!-- Left -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home mr-1"></i> Home</a>
            </li>
        </ul>

        <!-- Right -->
        <ul class="navbar-nav ml-auto align-items-center">


            <!-- User -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#"><i class="fas fa-user-circle fa-lg"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-cog mr-2"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar elevation-0">
        <a href="{{ route('home') }}" class="brand-link text-center">
            <i class="fas fa-project-diagram brand-image"></i>
            <span class="brand-text ml-2">PMS</span>
        </a>
        <div class="sidebar">
            @yield('sidebar-user')

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('programs.index') }}" class="nav-link {{ Request::routeIs('programs.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-project-diagram"></i><p>Programs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('projects.index') }}" class="nav-link {{ Request::routeIs('projects.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i><p>Projects</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('facilities.index') }}" class="nav-link {{ Request::routeIs('facilities.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i><p>Facilities</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('services.index') }}" class="nav-link {{ Request::routeIs('services.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i><p>Services</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('equipment.index') }}" class="nav-link {{ Request::routeIs('equipment.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tools"></i><p>Equipment</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('participants.index') }}" class="nav-link {{ Request::routeIs('participants.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i><p>Participants</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('outcomes.index') }}" class="nav-link {{ Request::routeIs('outcomes.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i><p>Outcomes</p>
                        </a>
                    </li>
                    @yield('sidebar-menu')
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        @hasSection('page-title')
        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0">@yield('page-title')</h1>
                @hasSection('breadcrumb')
                <ol class="breadcrumb float-sm-right">@yield('breadcrumb')</ol>
                @endif
            </div>
        </div>
        @endif

        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>
</div>

<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@yield('scripts')
</body>
</html>
