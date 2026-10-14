<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Medical Laboratory Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --hospital-primary: #0d6ea8;
            --hospital-primary-dark: #0a567c;
            --hospital-accent: #3dc0b5;
            --hospital-soft: #eaf7fb;
            --hospital-surface: #ffffff;
            --hospital-border: #dfeaf3;
            --hospital-text: #1f2d3d;
            --hospital-muted: #5d6f82;
        }

        body {
            background: linear-gradient(180deg, #f3fbff 0%, #edf4f8 100%);
            color: var(--hospital-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, var(--hospital-primary-dark) 0%, var(--hospital-primary) 100%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 4px 16px rgba(13, 110, 168, 0.12);
        }

        .navbar-brand {
            color: var(--hospital-primary-dark) !important;
            letter-spacing: 0.06em;
            font-weight: 900;
            font-size: 1.45rem;
            padding: 0.5rem 0.9rem;
            border-radius: 999px;
            background: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 6px 16px rgba(8, 58, 84, 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
        }

        .navbar-brand::before {
            content: "✚";
            display: inline-block;
            margin-right: 8px;
            font-size: 1.1rem;
            color: var(--hospital-primary);
        }

        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.82);
            font-weight: 500;
            padding: 0.75rem 0.9rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .navbar .nav-link.active {
            font-weight: 700;
        }

        .card {
            border: 1px solid var(--hospital-border) !important;
            border-radius: 1rem !important;
            background: var(--hospital-surface);
            box-shadow: 0 8px 18px rgba(13, 110, 168, 0.06) !important;
        }

        .card-header {
            background: linear-gradient(180deg, #f7fbff 0%, #f0f8fc 100%) !important;
            border-bottom: 1px solid var(--hospital-border) !important;
            color: var(--hospital-text);
            font-weight: 700;
        }

        .card-body,
        .table {
            color: var(--hospital-text);
        }

        .btn {
            border-radius: 0.75rem;
            font-weight: 600;
            padding: 0.7rem 1.1rem;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--hospital-primary) 0%, var(--hospital-accent) 100%);
            border-color: var(--hospital-primary);
            box-shadow: 0 8px 16px rgba(61, 192, 181, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--hospital-primary-dark) 0%, var(--hospital-primary) 100%);
            border-color: var(--hospital-primary-dark);
        }

        .btn-outline-primary {
            color: var(--hospital-primary);
            border-color: rgba(13, 110, 168, 0.35);
        }

        .btn-outline-primary:hover {
            background: var(--hospital-primary);
            border-color: var(--hospital-primary);
            color: #ffffff;
        }

        .text-primary {
            color: var(--hospital-primary) !important;
        }

        .bg-light {
            background-color: #f3f8fb !important;
        }

        .table thead th {
            background-color: #edf7fb;
            color: var(--hospital-text);
            font-weight: 700;
            white-space: nowrap;
            border-bottom: 1px solid var(--hospital-border);
        }

        .table td {
            border-color: #edf3f8;
            color: var(--hospital-text);
            vertical-align: middle;
        }

        .badge {
            border-radius: 999px;
            font-weight: 600;
            letter-spacing: 0.02em;
            padding: 0.5em 0.8em;
        }

        .text-bg-warning {
            background-color: #fff4d6 !important;
            color: #9b6b00 !important;
        }

        .text-bg-info {
            background-color: #dff6ff !important;
            color: #0f7991 !important;
        }

        .text-bg-success {
            background-color: #dcf8eb !important;
            color: #157347 !important;
        }

        .text-bg-secondary {
            background-color: #e9eef3 !important;
            color: #51677d !important;
        }

        .alert {
            border: none;
            border-radius: 0.9rem;
            box-shadow: 0 6px 16px rgba(13, 110, 168, 0.08);
        }

        .alert-success {
            background-color: #eafaf4;
            color: #146c43;
        }

        .alert-danger {
            background-color: #fff0f1;
            color: #b42318;
        }

        .display-6 {
            font-weight: 700;
            letter-spacing: -0.04em;
        }

        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand fw-semibold text-primary" href="{{ route('dashboard') }}">MedLab</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="nav-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}" href="{{ route('doctors.index') }}">Doctors</a>
                    <a class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}" href="{{ route('patients.index') }}">Patients</a>
                    <a class="nav-link {{ request()->routeIs('lab-tests.*') ? 'active' : '' }}" href="{{ route('lab-tests.index') }}">Lab Tests</a>
                    <a class="nav-link {{ request()->routeIs('lab-orders.*') ? 'active' : '' }}" href="{{ route('lab-orders.index') }}">Lab Orders</a>
                    <a class="nav-link {{ request()->routeIs('lab-results.*') ? 'active' : '' }}" href="{{ route('lab-results.index') }}">Lab Results</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
