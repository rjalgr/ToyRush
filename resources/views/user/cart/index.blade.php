@extends('layouts.app')
@section('title', 'My Cart')
@section('content')
<div class="container py-5" style="min-height: calc(100vh - 200px);">
    <h2 class="fw-bold mb-4">🛒 My Cart</h2>
    @if($cartItems->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:5rem">🛒</div>
        <h4 class="mt-3">Your cart is empty</h4>
        <p class="text-muted">Add some toys to get started!</p>
        <a href="{{ route('user.shop') }}" class="btn btn-primary">Start Shopping</a>
    </div>
    @else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    @foreach($cartItems as $item)
                    <div class="d-flex align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        @if($item->product->image)
                            <img src="{{ asset('storage/'.$item->product->image) }}" class="rounded me-3" style="width:70px;height:70px;object-fit:cover">
                        @else
                            <div class="me-3 d-flex align-items-center justify-content-center rounded bg-light" style="width:70px;height:70px;font-size:2rem"></div>
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-semibold">{{ $item->product->name }}</h6>
                            <p class="text-muted small mb-1">{{ $item->product->category->name }}</p>
                            <span class="fw-bold" style="color:#FF6B35">₱{{ number_format($item->product->current_price, 2) }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <form method="POST" action="{{ route('user.cart.update', $item) }}" class="d-flex align-items-center gap-2">
                                @csrf @method('PATCH')
                                <input type="number" name="quantity" class="form-control form-control-sm text-center" style="width:60px" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" onchange="this.form.submit()">
                            </form>
                            <span class="fw-bold" style="min-width:80px;text-align:right">₱{{ number_format($item->subtotal, 2) }}</span>
                            <form method="POST" action="{{ route('user.cart.remove', $item) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer bg-white text-end">
                    <form method="POST" action="{{ route('user.cart.clear') }}" onsubmit="return confirm('Clear all items?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>Clear Cart</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Order Summary</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">₱{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span class="fw-semibold">{{ $total >= 1000 ? 'FREE' : '₱150.00' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tax (12%)</span>
                        <span class="fw-semibold">₱{{ number_format($total * 0.12, 2) }}</span>
                    </div>
                    <hr>
                    @php $shipping = $total >= 1000 ? 0 : 150; $grandTotal = $total + $shipping + ($total * 0.12); @endphp
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold fs-5" style="color:#FF6B35">₱{{ number_format($grandTotal, 2) }}</span>
                    </div>
                    <a href="{{ route('user.checkout') }}" class="btn btn-primary w-100 btn-lg"><i class="bi bi-bag-check me-2"></i>Checkout</a>
                    <a href="{{ route('user.shop') }}" class="btn btn-outline-secondary w-100 mt-2 btn-sm">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection