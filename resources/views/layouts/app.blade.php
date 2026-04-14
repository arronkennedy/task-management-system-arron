<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #1e293b; }
        .sidebar a { color: #94a3b8; text-decoration: none; }
        .sidebar a:hover, .sidebar a.active { color: #fff; background: #334155; border-radius: 8px; }
        .nav-link { padding: 10px 16px; display: block; border-radius: 8px; }
        .badge-priority-low      { background: #10b981; }
        .badge-priority-medium   { background: #f59e0b; }
        .badge-priority-high     { background: #ef4444; }
        .badge-priority-critical { background: #7c3aed; }
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3" style="width:240px; min-width:240px;">
        <div class="text-white fw-bold fs-5 mb-4 px-2">
            <i class="bi bi-check2-square me-2"></i>TaskMS
        </div>
        <nav>
            <a href="{{ route('dashboard') }}"
               class="nav-link mb-1 {{ request()->routeIs('dashboard') ? 'active text-white' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
            <a href="{{ route('tasks.index') }}"
               class="nav-link mb-1 {{ request()->routeIs('tasks.*') ? 'active text-white' : '' }}">
                <i class="bi bi-list-task me-2"></i>Tasks
            </a>
            <a href="{{ route('categories.index') }}"
               class="nav-link mb-1 {{ request()->routeIs('categories.*') ? 'active text-white' : '' }}">
                <i class="bi bi-tag me-2"></i>Categories
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>