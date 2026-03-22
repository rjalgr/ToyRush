<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - ToyShop Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --admin-primary: #4F46E5; --admin-sidebar: #1E1E2E; --admin-sidebar-text: #ffffff; }
        body { background: #F7F8FC; }
        .sidebar { width: 260px; min-height: 100vh; background: var(--admin-sidebar); position: fixed; top: 0; left: 0; z-index: 1000; overflow-y: auto; }
        .sidebar-brand { padding: 20px; font-size: 1.3rem; font-weight: 800; color: #ffffff; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sidebar .nav-link { color: var(--admin-sidebar-text); padding: 10px 20px; border-radius: 8px; margin: 2px 10px; transition: all .2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(79,70,229,.3); color: #fff; }
        .sidebar-section { color: #ffffff; font-size: .7rem; text-transform: uppercase; letter-spacing: .1em; padding: 16px 20px 4px; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar { background: #fff; padding: 12px 24px; box-shadow: 0 1px 4px rgba(0,0,0,.08); display: flex; justify-content: space-between; align-items: center; }
        .page-content { padding: 24px; }
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.08); border-radius: 12px; }
        .stat-card { background: linear-gradient(135deg, var(--c1), var(--c2)); color: #fff; border-radius: 12px; padding: 20px; }
        .table thead th { background: #F7F8FC; border: none; font-weight: 600; font-size: .85rem; color: #555; }
        .btn-primary { background: var(--admin-primary); border-color: var(--admin-primary); }
        .btn-primary:hover { background: #4338CA; border-color: #4338CA; }
    </style>
    @stack('styles')
</head>
<body>
<div class="sidebar">
    <div class="sidebar-brand"> ToyRush <span style="color:#818CF8">Admin</span></div>
    <nav class="nav flex-column mt-3">
        <span class="sidebar-section">Main</span>
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>
        <span class="sidebar-section">Catalog</span>
        <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
            <i class="bi bi-box-seam me-2"></i>Products
        </a>
        <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <i class="bi bi-tags me-2"></i>Categories
        </a>
        <span class="sidebar-section">Sales</span>
        <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
            <i class="bi bi-bag-check me-2"></i>Orders
        </a>
        <span class="sidebar-section">Users</span>
        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="bi bi-people me-2"></i>Users
        </a>
        <span class="sidebar-section">Store</span>
        <a class="nav-link" href="{{ route('user.home') }}" target="_blank">
            <i class="bi bi-shop me-2"></i>View Store
        </a>
        <form method="POST" action="{{ route('logout') }}" class="px-3 mt-2">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm w-100"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
        </form>
    </nav>
</div>
<div class="main-content">
    <div class="topbar">
        <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
        <span class="text-muted small"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</span>
    </div>
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
