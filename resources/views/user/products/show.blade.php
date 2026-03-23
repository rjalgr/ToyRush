@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.shop') }}">Shop</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>
    <div class="row g-5">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}"
                    class="w-100"
                    style="height:450px;object-fit:contain;background:#f8f8f8;padding:12px;border-radius:12px;"
                    alt="{{ $product->name }}">
                @else
            <div class="d-flex align-items-center justify-content-center rounded" style="height:350px;background:#f8f8f8;font-size:6rem"></div>
            @endif
        </div>
        </div>
        <div class="col-md-7">
            <span class="badge bg-light text-dark mb-2">{{ $product->category->name }}</span>
            @if($product->is_featured)<span class="badge ms-1" style="background:#FFD700;color:#333">Featured</span>@endif
            <h1 class="h2 fw-bold mt-2">{{ $product->name }}</h1>
            <div class="d-flex align-items-center gap-3 my-3">
                @if($product->sale_price)
                    <span class="fs-4 fw-bold text-danger">₱{{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-decoration-line-through text-muted fs-5">₱{{ number_format($product->price, 2) }}</span>
                    <span class="badge" style="background:#FF6B35">{{ round((1 - $product->sale_price / $product->price) * 100) }}% OFF</span>
                @else
                    <span class="fs-3 fw-bold" style="color:#FF6B35">₱{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            <div class="row g-2 mb-3">
                @if($product->age_min || $product->age_max)
                <div class="col-auto">
                    <span class="badge bg-light text-dark"><i class="bi bi-person me-1"></i>Ages {{ $product->age_min }}-{{ $product->age_max ?? '+' }}</span>
                </div>
                @endif
                <div class="col-auto">
                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $product->stock > 0 ? $product->stock.' in Stock' : 'Out of Stock' }}
                    </span>
                </div>
            </div>
            <p class="text-muted">{{ $product->description }}</p>
            @auth
                @if($product->stock > 0)
                <form method="POST" action="{{ route('user.cart.add', $product) }}" class="d-flex gap-3 mt-4 align-items-center">
                    @csrf
                    <div style="max-width:120px">
                        <label class="form-label small fw-semibold">Quantity</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4"><i class="bi bi-cart-plus me-2"></i>Add to Cart</button>
                    </div>
                </form>
                @else
                    <button class="btn btn-secondary btn-lg mt-4" disabled>Out of Stock</button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-4"><i class="bi bi-box-arrow-in-right me-2"></i>Login to Purchase</a>
            @endauth
        </div>
    </div>
    @if($related->count())
    <div class="mt-5">
        <h3 class="fw-bold mb-4">You May Also Like</h3>
        <div class="row g-4">
            @foreach($related as $product)
            <div class="col-6 col-md-3">
                @include('user.products._card', compact('product'))
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
