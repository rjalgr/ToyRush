@extends('layouts.app')
@section('title', 'Shop')
@section('content')
<div class="card product-card h-100">
    <a href="{{ route('user.products.show', $product) }}" class="position-relative d-block">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
        @else
            <div class="product-img d-flex align-items-center justify-content-center" style="font-size:4rem;background:#f8f8f8"></div>
        @endif
        @if($product->sale_price)
            <span class="badge badge-sale position-absolute top-0 start-0 m-2">SALE</span>
        @endif
        @if($product->is_featured)
            <span class="badge position-absolute top-0 end-0 m-2" style="background:#FFD700;color:#333"></span>
        @endif
    </a>
    <div class="card-body d-flex flex-column">
        <p class="text-muted small mb-1">{{ $product->category->name }}</p>
        <h6 class="fw-bold mb-2">
            <a href="{{ route('user.products.show', $product) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
        </h6>
        <div class="mt-auto">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    @if($product->sale_price)
                        <span class="price-old">₱{{ number_format($product->price, 2) }}</span>
                        <span class="price-new d-block">₱{{ number_format($product->sale_price, 2) }}</span>
                    @else
                        <span class="price-new">₱{{ number_format($product->price, 2) }}</span>
                    @endif
                </div>
                @if($product->stock > 0)
                    <span class="badge bg-success-subtle text-success small">In Stock</span>
                @else
                    <span class="badge bg-danger-subtle text-danger small">Out of Stock</span>
                @endif
            </div>
            @auth
                @if($product->stock > 0)
                <form method="POST" action="{{ route('user.cart.add', $product) }}">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-cart-plus me-1"></i>Add to Cart
                    </button>
                </form>
                @else
                    <button class="btn btn-secondary btn-sm w-100" disabled>Out of Stock</button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">Login to Buy</a>
            @endauth
        </div>
    </div>
</div>