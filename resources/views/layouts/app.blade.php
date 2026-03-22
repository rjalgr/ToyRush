<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ToyShop') - ToyRush PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --toy-primary: #FF6B35; --toy-secondary: #FFD700; --toy-dark: #2D2D2D; --toy-light: #FFF8F0; }
        body { background: var(--toy-light); font-family: 'Segoe UI', sans-serif; }

        /* ── Navbar ── */
        .navbar {
            background: transparent;
            box-shadow: none;
            padding: 0 !important;
            height: 55px;
        }
        .navbar .container { height: 55px; }
        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--toy-primary) !important;
            line-height: 1;
            padding: 0;
        }
        .navbar-brand span { color: var(--toy-secondary); }
        .navbar .nav-link {
            font-size: 0.9rem;
            font-weight: 500;
            color: #333 !important;
            padding: 0 14px !important;
            line-height: 58px;
        }
        .navbar .nav-link:hover { color: var(--toy-primary) !important; }
        .navbar .btn { font-size: 0.85rem; }
        .cart-count {
            background: var(--toy-primary);
            color: #fff;
            border-radius: 50%;
            font-size: 0.65rem;
            padding: 1px 5px;
            position: relative;
            top: -8px;
            left: -4px;
        }

        /* ── Buttons ── */
        .btn-primary { background: var(--toy-primary); border-color: var(--toy-primary); }
        .btn-primary:hover { background: #e55a27; border-color: #e55a27; }
        .btn-outline-primary { color: var(--toy-primary); border-color: var(--toy-primary); }
        .btn-outline-primary:hover { background: var(--toy-primary); border-color: var(--toy-primary); color: #fff; }
        .text-primary { color: var(--toy-primary) !important; }
        .bg-primary { background: var(--toy-primary) !important; }

        /* ── Products ── */
        .product-card { transition: transform .2s, box-shadow .2s; border: none; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }
        .product-img { height: 200px; object-fit: cover; background: #f0f0f0; }
        .badge-sale { background: var(--toy-primary); color: #fff; font-size: .7rem; }
        .price-old { text-decoration: line-through; color: #999; font-size: .85rem; }
        .price-new { color: var(--toy-primary); font-weight: 700; font-size: 1.1rem; }

        /* ── Hero ── */
        .hero-section { background: linear-gradient(135deg, #FF6B35 0%, #FFD700 100%); color: #fff; padding: 80px 0; }

        /* ── Category ── */
        .category-card { border: none; background: #fff; border-radius: 12px; transition: transform .2s; text-align: center; padding: 20px; }
        .category-card:hover { transform: translateY(-3px); }

        /* ── Footer ── */
        .footer { background: var(--toy-dark); color: #ccc; padding: 40px 0 20px; }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('user.home') }}">Toy<span>Rush</span></a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('user.home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('user.shop') }}">Shop</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('user.cart') }}" class="btn btn-outline-secondary btn-sm position-relative">
                        <i class="bi bi-cart3"></i>
                        @php $cartCount = auth()->user()->cartItems()->count(); @endphp
                        @if($cartCount > 0)
                            <span class="cart-count">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width:200px">
                            <li><a class="dropdown-item py-2" href="{{ route('user.orders.index') }}"><i class="bi bi-bag me-2 text-muted"></i>My Orders</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('user.profile') }}"><i class="bi bi-person me-2 text-muted"></i>My Profile</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-muted"></i>Admin Panel</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

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

<main class="flex-grow-1">
@yield('content')
</main>

<footer class="footer mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-white">ToyRush PH</h5>
                <p>Your one-stop shop for quality toys in the PH.</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-white">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('user.shop') }}" class="text-decoration-none text-secondary">Shop</a></li>
                    <li><a href="#" class="text-decoration-none text-secondary">About Us</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="text-white">Contact</h6>
                <p><i class="bi bi-envelope me-2"></i>hello@toyrush.ph</p>
                <p><i class="bi bi-telephone me-2"></i>+63 917 123 4567</p>
            </div>
        </div>
        <hr class="border-secondary">
        <p class="text-center text-secondary mb-0">© {{ date('Y') }} ToyRush PH. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>