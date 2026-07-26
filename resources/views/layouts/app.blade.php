<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Bus Maintenance System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #2c3e50;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: bold;
            color: #fff !important;
            padding: 0;
        }

        .navbar-brand img.navbar-logo {
            height: 32px;
            width: auto;
            object-fit: contain;
            vertical-align: middle;
            display: block;
        }

        .navbar-brand .brand-text {
            color: #fff;
            font-size: 1rem;
            margin: 0;
        }

        .sidebar {
            background-color: #34495e;
            min-height: 100vh;
            color: #fff;
            padding-top: 0;
        }

        .sidebar .nav-link {
            color: #bdc3c7 !important;
            border-left: 3px solid transparent;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #2c3e50;
            border-left-color: #3498db;
            color: #fff !important;
        }

        .sidebar .nav-link i {
            margin-right: 0.75rem;
        }

        .main-content {
            padding: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.875rem;
        }

        .badge {
            padding: 0.35rem 0.65rem;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 0.5rem;
        }

        .stat-card.good {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .stat-card.maintenance {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card.damaged {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        footer {
            background-color: #2c3e50;
            color: #bdc3c7;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .alert {
            border: none;
            border-radius: 0.5rem;
        }

        .pagination-wrapper .pagination {
            gap: 0.35rem;
            margin-bottom: 0;
        }

        .pagination-wrapper .page-item .page-link {
            min-width: 2.45rem;
            height: 2.45rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.35rem 0.7rem;
            border: 1px solid #dfe3e8;
            color: #334155;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .pagination-wrapper .page-item .page-link:hover {
            background-color: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .pagination-wrapper .page-item.active .page-link {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            border-color: #2563eb;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.2);
        }

        .pagination-wrapper .page-item.disabled .page-link {
            opacity: 0.55;
            background-color: #f8fafc;
            color: #94a3b8;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -300px;
                width: 300px;
                transition: left 0.3s ease;
                z-index: 1050;
            }

            .sidebar.active {
                left: 0;
            }
        }
    </style>

    @yield('extra-css')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/damri-logo.svg') }}" alt="DAMRI" class="navbar-logo">
                <span class="brand-text">Bus Maintenance System</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ auth()->user()->name ?? 'mekanik' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse  top-0 min-vh-100 overflow-y-auto">
                    <div class=" position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home', 'dashboard') ? 'active' : '' }}"
                                    href="{{ route('home') }}">
                                    <i class="fas fa-chart-line"></i> Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}"
                                    href="{{ route('vehicles.index') }}">
                                    <i class="fas fa-car"></i> Data Kendaraan
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}"
                                    href="{{ route('schedules.index') }}">
                                    <i class="fas fa-calendar-alt"></i> Jadwal Servis
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('records.*') ? 'active' : '' }}"
                                    href="{{ route('records.index') }}">
                                    <i class="fas fa-history"></i> Riwayat Pemeliharaan
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('monitoring.index') ? 'active' : '' }}"
                                    href="{{ route('monitoring.index') }}">
                                    <i class="fas fa-desktop"></i> Monitoring Bus
                                </a>
                            </li>
                            @if (Auth::check() && Auth::user()->isSopir())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('inspections.*') ? 'active' : '' }}"
                                        href="{{ route('inspections.index') }}">
                                        <i class="fas fa-clipboard-list"></i> Laporan AT/3
                                    </a>
                                </li>
                            @endif
                            @if (Auth::check() && Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('report.*', 'reports.*') ? 'active' : '' }}"
                                        href="{{ route('report.dashboard') }}">
                                        <i class="fas fa-file-alt"></i> Laporan
                                    </a>
                                </li>
                            @endif

                            {{-- Admin Settings akan ditambahkan jika ada halaman khusus untuk admin --}}
                        </ul>

                        <hr class="my-3">
                        <div class="text-muted small px-3">
                            <p><strong>Role:</strong> {{ auth()->user()->role_label ?? '-' }}</p>
                            <p><strong>Status:</strong>
                                @if (auth()->user()->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Non-Aktif</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                @else
                    <main class="col-12 main-content">
                    @endauth
                    <!-- Alert Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h5>{{ __('Validation Error') }}</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-auto py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; 2026 Bus Maintenance System. All rights reserved.</p>
                    <p class="small">Developed by Nandang Aryanto</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js untuk statistik (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    @yield('extra-js')
</body>

</html>
