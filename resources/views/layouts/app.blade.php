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
            --toy-primary:   #FF6B35;
            --toy-secondary: #FFD700;
            --toy-dark:      #2D2D2D;
            --toy-light:     #FFF8F0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { width: 100%; overflow-x: hidden; }
        body {
            background: var(--toy-light);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main { flex: 1 0 auto; }

        /* ── Navbar ── */
        .navbar {
            background: transparent;
            padding: 0 !important;
            height: 58px;
            width: 100%;
        }
        .navbar .container { height: 58px; }
        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--toy-primary) !important;
            padding: 0;
            line-height: 1;
        }
        .navbar-brand span { color: var(--toy-secondary); }
        ..navbar .nav-link {
        font-size: .9rem;
        font-weight: 500;
        color: #333 !important;
        padding: 0 12px !important;
        line-height: 58px;
        white-space: nowrap;
}
        .navbar .nav-link:hover { color: var(--toy-primary) !important; }
        .navbar .btn { font-size: .85rem; }
        .cart-count {
            background: var(--toy-primary);
            color: #fff;
            border-radius: 50%;
            font-size: .65rem;
            padding: 1px 5px;
            position: relative;
            top: -8px;
            left: -4px;
        }

        /* ── Buttons ── */
        .btn-primary               { background: var(--toy-primary); border-color: var(--toy-primary); }
        .btn-primary:hover         { background: #e55a27;            border-color: #e55a27; }
        .btn-outline-primary       { color: var(--toy-primary);      border-color: var(--toy-primary); }
        .btn-outline-primary:hover { background: var(--toy-primary); border-color: var(--toy-primary); color: #fff; }
        .text-primary              { color: var(--toy-primary) !important; }
        .bg-primary                { background: var(--toy-primary) !important; }

        /* ── Products ── */
        .product-card       { transition: transform .2s, box-shadow .2s; border: none; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }
        .product-img        { height: 200px; object-fit: cover; background: #f0f0f0; }
        .badge-sale         { background: var(--toy-primary); color: #fff; font-size: .7rem; }
        .price-old          { text-decoration: line-through; color: #999; font-size: .85rem; }
        .price-new          { color: var(--toy-primary); font-weight: 700; font-size: 1.1rem; }

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
            transition: transform .10s;
            text-align: center;
            padding: 20px;
        }
        .category-card:hover { transform: translateY(-3px); }

        /* ── Footer ── */
        .footer {
            flex-shrink: 0;
            background: transparent;
            border-top: 1px solid rgba(0,0,0,.08);
            color: #555;
            padding: 3rem 0 2rem;
        }
        .footer h5,
        .footer h6     { font-weight: 600; color: #333; }
        .footer-link   { transition: all .2s ease; display: block; padding: .25rem 0; }
        .footer-link:hover { color: var(--toy-primary) !important; transform: translateX(4px); }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── Navbar ── --}}
<nav class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="{{ route('user.home') }}">Toy<span>Rush</span></a>
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.home') ? 'active fw-semibold' : '' }}"
                       href="{{ route('user.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.shop') ? 'active fw-semibold' : '' }}"
                       href="{{ route('user.shop') }}">Shop</a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                @auth
                    {{-- Cart --}}
                    <a href="{{ route('user.cart') }}"
                       class="btn btn-sm position-relative me-1"
                       style="background:var(--toy-primary);border-color:var(--toy-primary);color:#fff;border-radius:8px;padding:6px 14px;">
                        <i class="bi bi-cart3 me-1"></i>Cart
                        @php $cartCount = auth()->user()->cartItems()->count(); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                                  style="background:#2D2D2D;font-size:.6rem">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- User dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle d-flex align-items-center gap-1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold"
                                  style="width:22px;height:22px;font-size:.7rem;background:var(--toy-primary)">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-1" style="min-width:220px;border-radius:12px;">
                            {{-- User info header --}}
                            <li class="px-3 py-2 border-bottom">
                                <p class="fw-semibold mb-0 small">{{ auth()->user()->name }}</p>
                                <p class="text-muted mb-0" style="font-size:.75rem">{{ auth()->user()->email }}</p>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 mt-1" href="{{ route('user.orders.index') }}">
                                    <i class="bi bi-bag me-2" style="color:var(--toy-primary)"></i>My Orders
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('user.profile') }}">
                                    <i class="bi bi-person me-2" style="color:var(--toy-primary)"></i>My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('user.cart') }}">
                                    <i class="bi bi-cart3 me-2" style="color:var(--toy-primary)"></i>My Cart
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2 text-muted"></i>Admin Panel
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
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

{{-- ── Flash messages ── --}}
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

{{-- ── Page content ── --}}
<main>
    @yield('content')
</main>

{{-- ── Footer ── --}}
<footer class="footer mt-auto">
    <div class="container">
        <div class="row g-4 g-md-5">
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-3">Toy<span style="color:var(--toy-primary)">Rush</span> PH</h5>
                <p class="mb-3 small">Your trusted one-stop shop for quality toys across the Philippines. Fast delivery nationwide!</p>
            </div>
            <div class="col-lg-2 col-md-6">
                <h6 class="mb-3">Shop</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('user.home') }}" class="text-muted text-decoration-none footer-link">Home</a></li>
                    <li><a href="{{ route('user.shop') }}" class="text-muted text-decoration-none footer-link">Products</a></li>
                    <li><a href="{{ route('user.cart') }}" class="text-muted text-decoration-none footer-link">Cart</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6">
                <h6 class="mb-3">Account</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('user.profile') }}"      class="text-muted text-decoration-none footer-link">Profile</a></li>
                    <li><a href="{{ route('user.orders.index') }}" class="text-muted text-decoration-none footer-link">Orders</a></li>
                    <li><a href="{{ route('login') }}"             class="text-muted text-decoration-none footer-link">Login</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="mb-3">Contact Info</h6>
                <p class="mb-1 small"><i class="bi bi-geo-alt-fill me-2" style="color:var(--toy-primary)"></i>Metro Manila, Philippines</p>
                <p class="mb-1 small"><i class="bi bi-telephone-fill me-2 text-success"></i>+63 917 123 4567</p>
                <p class="mb-3 small"><i class="bi bi-envelope-fill me-2 text-warning"></i>hello@toyrush.ph</p>
                <div>
                </div>
            </div>
        </div>
        <hr class="my-4 opacity-25">
        <div class="row align-items-center">
            <div class="col-md-6">
                <ul class="list-inline mb-3 mb-md-0">
                    <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none small footer-link">Privacy Policy</a></li>
                    <li class="list-inline-item text-muted">|</li>
                    <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none small footer-link">Terms of Service</a></li>
                    <li class="list-inline-item text-muted">|</li>
                    <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none small footer-link">Shipping Info</a></li>
                </ul>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted mb-0 small">&copy; {{ date('Y') }} ToyRush PH. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>