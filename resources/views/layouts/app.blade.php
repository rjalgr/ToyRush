<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ToyRush') - ToyRush PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary:   #FF6B35;
            --secondary: #FFD700;
            --dark:      #2D2D2D;
            --light:     #FFF8F0;
        }

        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: var(--light);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        main { flex: 1 0 auto; }

        /* ── Navbar ── */
        .navbar {
        background:transparent;
        box-shadow:none;
        border-bottom:none;
        padding: 0 !important;
        min-height: 60px;
        position: relative;
        width: 100%;
        z-index: 100;
}
    .navbar .container {
    min-height: 60px;
    display: flex;
    align-items: center;
}
    .navbar-brand {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--primary) !important;
    line-height: 1;
    padding: 0;
    margin-right: 28px;
}
    .navbar-brand span { color: var(--secondary); }
    .navbar .nav-link {
    font-size: .9rem;
    font-weight: 500;
    color: #444 !important;
    padding: 0 14px !important;
    line-height: 60px;
    white-space: nowrap;
    transition: color .15s;
}
    .navbar .nav-link:hover,
    .navbar .nav-link.active { color: var(--primary) !important; }
    .navbar .btn { font-size: .85rem; }
    .navbar-toggler:focus { box-shadow: none; }

    /* mobile nav */
    @media (max-width: 767.98px) {
    .navbar .nav-link  { line-height: 2.4; padding: 0 8px !important; }
    .navbar-collapse   { padding: 8px 0 12px; border-top: 1px solid #eee; }
    .navbar-collapse .d-flex { flex-wrap: wrap; gap: 8px !important; padding-top: 8px; }
}

        /* ── Buttons ── */
        .btn-primary               { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover         { background: #e55a27;        border-color: #e55a27; }
        .btn-outline-primary       { color: var(--primary);      border-color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
        .text-primary  { color: var(--primary) !important; }
        .bg-primary    { background: var(--primary) !important; }

        /* ── Product cards ── */
        .product-card       { border: none; transition: transform .2s, box-shadow .2s; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }
        .product-img        { height: 200px; object-fit: cover; background: #f0f0f0; }
        .badge-sale         { background: var(--primary); color: #fff; font-size: .7rem; }
        .price-old          { text-decoration: line-through; color: #999; font-size: .85rem; }
        .price-new          { color: var(--primary); font-weight: 700; font-size: 1.1rem; }

        /* ── Hero ── */
        .hero-section {
            background: linear-gradient(135deg, #FF6B35 0%, #FFD700 100%);
            color: #fff;
            padding: 80px 0;
        }

        /* ── Category cards ── */
        .category-card {
            border: none;
            background: #fff;
            border-radius: 12px;
            text-align: center;
            padding: 20px;
            transition: transform .2s;
        }
        .category-card:hover { transform: translateY(-3px); }

        /* ── Footer ── */
        .footer {
            flex-shrink: 0;
            background: var(--dark);
            color: #aaa;
            padding: 48px 0 24px;
            width: 100%;
        }
        .footer h5, .footer h6 { color: #fff; font-weight: 600; }
        .footer-link {
            display: block;
            padding: .25rem 0;
            color: #aaa;
            text-decoration: none;
            transition: color .2s, transform .2s;
        }
        .footer-link:hover { color: var(--primary); transform: translateX(4px); }
        .footer hr { border-color: rgba(255,255,255,.1); }
        .footer .text-muted { color: #777 !important; }
    </style>
    @stack('styles')
</head>
<body>

{{-- ════ NAVBAR ════ --}}
<nav class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="{{ route('user.home') }}">Toy<span>Rush</span></a>

        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}"
                       href="{{ route('user.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.shop*','user.products*') ? 'active' : '' }}"
                       href="{{ route('user.shop') }}">Shop</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                @auth
                    {{-- Cart button --}}
                    <a href="{{ route('user.cart') }}"
                       class="btn btn-sm position-relative"
                       style="background:var(--primary);color:#fff;border:none;border-radius:8px;padding:6px 14px;">
                        <i class="bi bi-cart3 me-1"></i>Cart
                        @php $cartCount = auth()->user()->cartItems()->count(); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                                  style="background:#222;font-size:.6rem;min-width:18px">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- User dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle d-flex align-items-center gap-2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold text-white"
                                  style="width:22px;height:22px;font-size:.7rem;background:var(--primary);flex-shrink:0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                            style="min-width:220px;border-radius:12px;overflow:hidden">
                            {{-- Header --}}
                            <li class="px-3 py-2 bg-light border-bottom">
                                <p class="fw-semibold mb-0 small">{{ auth()->user()->name }}</p>
                                <p class="text-muted mb-0" style="font-size:.75rem">{{ auth()->user()->email }}</p>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('user.orders.index') }}">
                                    <i class="bi bi-bag me-2" style="color:var(--primary)"></i>My Orders
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('user.profile') }}">
                                    <i class="bi bi-person me-2" style="color:var(--primary)"></i>My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('user.cart') }}">
                                    <i class="bi bi-cart3 me-2" style="color:var(--primary)"></i>My Cart
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2 text-muted"></i>Admin Panel
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}"    class="btn btn-outline-primary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ════ FLASH MESSAGES ════ --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-0 rounded-0" role="alert">
        <div class="container"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
        <div class="container"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ════ CONTENT ════ --}}
<main>
    @yield('content')
</main>

{{-- ════ FOOTER ════ --}}
<footer class="footer">
    <div class="container">
        <div class="row g-4 g-md-5">

            {{-- Brand --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="mb-3">Toy<span style="color:var(--primary)">Rush</span> PH</h5>
                <p class="small mb-3">Your trusted one-stop shop for quality toys across the Philippines. Fast delivery nationwide!</p>
                <div class="d-flex gap-3">
                    <a href="#" class="footer-link" style="font-size:1.2rem"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="footer-link" style="font-size:1.2rem"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="footer-link" style="font-size:1.2rem"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>

            {{-- Shop links --}}
            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="mb-3">Shop</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('user.home') }}" class="footer-link">Home</a></li>
                    <li><a href="{{ route('user.shop') }}" class="footer-link">Products</a></li>
                    <li><a href="{{ route('user.cart') }}" class="footer-link">Cart</a></li>
                </ul>
            </div>

            {{-- Account links --}}
            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="mb-3">Account</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('user.profile') }}"      class="footer-link">Profile</a></li>
                    <li><a href="{{ route('user.orders.index') }}" class="footer-link">Orders</a></li>
                    <li><a href="{{ route('login') }}"             class="footer-link">Login</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="mb-3">Contact</h6>
                <p class="small mb-2"><i class="bi bi-geo-alt-fill me-2" style="color:var(--primary)"></i>Metro Manila, Philippines</p>
                <p class="small mb-2"><i class="bi bi-telephone-fill me-2 text-success"></i>+63 917 123 4567</p>
                <p class="small mb-0"><i class="bi bi-envelope-fill me-2" style="color:var(--secondary)"></i>hello@toyrush.ph</p>
            </div>
        </div>

        <hr class="mt-4 mb-3">

        <div class="row align-items-center g-2">
            <div class="col-md-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="#" class="footer-link small">Privacy Policy</a></li>
                    <li class="list-inline-item" style="color:#555">|</li>
                    <li class="list-inline-item"><a href="#" class="footer-link small">Terms of Service</a></li>
                    <li class="list-inline-item" style="color:#555">|</li>
                    <li class="list-inline-item"><a href="#" class="footer-link small">Shipping Info</a></li>
                </ul>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="small mb-0" style="color:#666">&copy; {{ date('Y') }} ToyRush PH. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>