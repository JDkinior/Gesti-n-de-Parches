<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Gestión de Parches' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --dark-bg: #0f172a;
            --dark-secondary: #1e293b;
            --dark-tertiary: #334155;
            --gray-light: #f8fafc;
            --primary-blue: #0ea5e9;
            --primary-orange: #f97316;
            --primary-green: #10b981;
            --primary-red: #ef4444;
        }

        * {
            transition: color 0.2s, background-color 0.2s, box-shadow 0.2s;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: #0f172a;
            min-height: 100vh;
            color: #e2e8f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar moderno */
        .navbar {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: 0.05rem;
            font-size: 1.5rem;
            color: #0ea5e9 !important;
        }

        .navbar-brand i {
            margin-right: 0.5rem;
        }

        .nav-link {
            color: rgba(226, 232, 240, 0.7) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            position: relative;
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .nav-link:hover {
            color: #0ea5e9 !important;
            background: rgba(14, 165, 233, 0.1);
        }

        .nav-link.active {
            color: #0ea5e9 !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 3px;
            background: #0ea5e9;
            border-radius: 2px;
        }

        /* Cards mejoradas */
        .card-soft {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.1);
            transition: all 0.3s ease;
        }

        .card-soft:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            transform: translateY(-4px);
            border-color: rgba(226, 232, 240, 0.2);
        }

        .card-header {
            border-bottom: 1px solid rgba(226, 232, 240, 0.1) !important;
            background: rgba(30, 41, 59, 0.8) !important;
            color: #f8fafc !important;
        }

        .card-body {
            background: rgba(30, 41, 59, 0.8) !important;
            color: #e2e8f0 !important;
        }

        .card {
            background: rgba(30, 41, 59, 0.8) !important;
            border: 1px solid rgba(226, 232, 240, 0.1) !important;
            color: #e2e8f0 !important;
        }

        /* Botones modernos */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background-color: #0ea5e9;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.2);
            color: #ffffff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0284c7;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            color: #e2e8f0;
            border: 1px solid rgba(226, 232, 240, 0.3);
        }

        .btn-outline-secondary:hover {
            background: rgba(226, 232, 240, 0.1);
            border-color: rgba(226, 232, 240, 0.5);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.75rem;
            height: 2.75rem;
            padding: 0 0.85rem;
            border: 0;
            line-height: 1;
        }

        .action-btn-view {
            border-top-left-radius: 0.65rem !important;
            border-bottom-left-radius: 0.65rem !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .action-btn-middle {
            border-radius: 0 !important;
        }

        .action-btn-delete {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
            border-top-right-radius: 0.65rem !important;
            border-bottom-right-radius: 0.65rem !important;
        }

        /* Badges mejorados */
        .badge {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Tablas mejoradas */
        .table {
            color: #e2e8f0 !important;
            border-collapse: separate;
            border-spacing: 0 8px;
            background: rgba(30, 41, 59, 0.8) !important;
        }

        .table thead {
            background: rgba(51, 65, 85, 0.6) !important;
        }

        .table thead th {
            border: none;
            color: #f8fafc !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05rem;
            background: rgba(51, 65, 85, 0.6) !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.1) !important;
        }

        .table tbody tr {
            background: rgba(30, 41, 59, 0.6) !important;
            border-radius: 8px;
            border: 1px solid rgba(226, 232, 240, 0.1) !important;
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(51, 65, 85, 0.5) !important;
        }

        .table tbody td {
            border: none !important;
            padding: 1rem;
            vertical-align: middle;
            color: #e2e8f0 !important;
            background: rgba(30, 41, 59, 0.6) !important;
        }

        .table tbody td:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table tbody td:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Alertas mejoradas */
        .alert {
            border: none;
            border-radius: 10px;
            border-left: 4px solid;
            background: rgba(51, 65, 85, 0.6);
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.15);
            color: #86efac;
            border-left-color: #10b981;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-left-color: #ef4444;
        }

        /* Formularios mejorados */
        .form-control,
        .form-select {
            border: 1px solid rgba(226, 232, 240, 0.2);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: rgba(51, 65, 85, 0.5);
            color: #f8fafc;
        }

        .form-control::placeholder {
            color: rgba(226, 232, 240, 0.4);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0ea5e9;
            background: rgba(51, 65, 85, 0.7);
            box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.2);
            color: #f8fafc;
        }

        .form-label {
            font-weight: 600;
            color: #f8fafc;
            margin-bottom: 0.6rem;
        }

        /* User menu mejorado */
        .user-menu {
            background: rgba(14, 165, 233, 0.1);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            backdrop-filter: blur(10px);
        }

        /* KPI Cards */
        .kpi-card {
            position: relative;
            overflow: hidden;
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: -50px;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .kpi-card .display-6 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        /* Main container */
        main {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-soft {
            animation: fadeInUp 0.5s ease;
        }

        /* Footer spacing */
        footer {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            main {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-shield-alt"></i> Gestión de Parches
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('systems.*') ? 'active' : '' }}" href="{{ route('systems.index') }}">
                                <i class="fas fa-server"></i> Sistemas
                            </a>
                        </li>
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-3">
                    @auth
                        <div class="user-menu d-flex align-items-center gap-2">
                            <i class="fas fa-user-circle"></i>
                            <span class="text-white">{{ auth()->user()->name }}</span>
                            <span class="badge text-bg-light" style="color: #667eea !important;">{{ auth()->user()->role }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light">
                                <i class="fas fa-sign-out-alt"></i> Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-sign-in-alt"></i> Acceder
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="container-fluid px-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <strong>Se encontraron errores en el formulario.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
