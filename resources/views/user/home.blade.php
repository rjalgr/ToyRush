@extends('layouts.app')
@section('title', 'Home')
@section('content')
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3"> Welcome to ToyRush PH</h1>
        <p class="lead mb-4 opacity-90">Quality toys for every child!</p>
        <a href="{{ route('user.shop') }}" class="btn btn-light btn-lg px-5 fw-semibold" style="color:#FF6B35">
            <i class="bi bi-bag me-2"></i>Shop Now
        </a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">Shop by Category</h2>
        <div class="row g-3 justify-content-center">
            @foreach($categories as $cat)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('user.shop', ['category' => $cat->slug]) }}" class="text-decoration-none">
                    <div class="category-card shadow-sm">
                        <div style="font-size:2rem;margin-bottom:8px">
                            @php
                                $icons = ['Action Figures'=>'','Board Games'=>'','Educational Toys'=>'','Stuffed Animals'=>'','Building Blocks'=>'','Remote Control'=>''];
                                echo $icons[$cat->name] ?? '';
                            @endphp
                        </div>
                        <p class="mb-0 small fw-semibold text-dark">{{ $cat->name }}</p>
                        <p class="mb-0 text-muted" style="font-size:.7rem">{{ $cat->products_count }} items</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

@if($featured->count())
<section class="py-4 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0"> Featured Toys</h2>
            <a href="{{ route('user.shop') }}" class="btn btn-outline-primary btn-sm">View All</a>
        </div>
        <div class="row g-4">
            @foreach($featured as $product)
            <div class="col-6 col-md-4 col-lg-3">
                @include('user.products._card', compact('product'))
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">New Arrivals</h2>
            <a href="{{ route('user.shop') }}" class="btn btn-outline-primary btn-sm">View All</a>
        </div>
        <div class="row g-4">
            @foreach($newArrivals as $product)
            <div class="col-6 col-md-4 col-lg-3">
                @include('user.products._card', compact('product'))
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-4" style="background:#FF6B35">
    <div class="container">
        <div class="row text-white text-center g-4">
            <div class="col-md-3"><i class="bi bi-shield-check fs-2"></i><p class="fw-bold mb-0 mt-2">Safe & Certified</p></div>
            <div class="col-md-3"><i class="bi bi-truck fs-2"></i><p class="fw-bold mb-0 mt-2">Free Ship over ₱1000</p></div>
            <div class="col-md-3"><i class="bi bi-arrow-counterclockwise fs-2"></i><p class="fw-bold mb-0 mt-2">Easy Returns</p></div>
            <div class="col-md-3"><i class="bi bi-headset fs-2"></i><p class="fw-bold mb-0 mt-2">24/7 Support</p></div>
        </div>
    </div>
</section>
@endsection