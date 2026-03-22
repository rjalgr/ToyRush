@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Checkout</h2>
    <div class="row g-4">
        <div class="col-lg-7">
            <form method="POST" action="{{ route('user.orders.store') }}">
                @csrf
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">📦 Shipping Information</h6></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name *</label>
                                <input type="text" name="shipping_name" class="form-control" value="{{ old('shipping_name', auth()->user()->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email *</label>
                                <input type="email" name="shipping_email" class="form-control" value="{{ old('shipping_email', auth()->user()->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="shipping_phone" class="form-control" value="{{ old('shipping_phone', auth()->user()->phone) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">City *</label>
                                <input type="text" name="shipping_city" class="form-control" value="{{ old('shipping_city') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Street Address *</label>
                                <input type="text" name="shipping_address" class="form-control" value="{{ old('shipping_address', auth()->user()->address) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Province</label>
                                <input type="text" name="shipping_state" class="form-control" value="{{ old('shipping_state') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">ZIP Code</label>
                                <input type="text" name="shipping_zip" class="form-control" value="{{ old('shipping_zip') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Payment Method</h6></div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach(['cod'=>['label'=>'Cash on Delivery','icon'=>''],'gcash'=>['label'=>'GCash','icon'=>''],'card'=>['label'=>'Credit/Debit Card','icon'=>'']] as $value => $opt)
                            <div class="col-md-4">
                                <div class="form-check border rounded p-3">
                                    <input class="form-check-input" type="radio" name="payment_method" value="{{ $value }}" id="pay-{{ $value }}" {{ old('payment_method','cod') === $value ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="pay-{{ $value }}" style="cursor:pointer">
                                        <span style="font-size:1.5rem">{{ $opt['icon'] }}</span>
                                        <p class="mb-0 small fw-semibold mt-1">{{ $opt['label'] }}</p>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Notes (Optional)</h6></div>
                    <div class="card-body">
                        <textarea name="notes" class="form-control" rows="3" placeholder="Special instructions...">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100"><i class="bi bi-bag-check me-2"></i>Place Order (₱{{ number_format($total, 2) }})</button>
            </form>
        </div>
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 sticky-top" style="top:80px">
                <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Order Summary</h6></div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="me-3" style="font-size:1.8rem"></div>
                        <div class="flex-grow-1">
                            <p class="mb-0 small fw-semibold">{{ $item->product->name }}</p>
                            <p class="mb-0 text-muted" style="font-size:.75rem">Qty: {{ $item->quantity }}</p>
                        </div>
                        <span class="fw-semibold small">₱{{ number_format($item->product->current_price * $item->quantity, 2) }}</span>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between mb-1 small"><span class="text-muted">Subtotal</span><span>₱{{ number_format($subtotal, 2) }}</span></div>
                    <div class="d-flex justify-content-between mb-1 small"><span class="text-muted">Shipping</span><span>{{ $shipping == 0 ? 'FREE' : '₱'.number_format($shipping, 2) }}</span></div>
                    <div class="d-flex justify-content-between mb-2 small"><span class="text-muted">Tax (12%)</span><span>₱{{ number_format($tax, 2) }}</span></div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold"><span>Total</span><span style="color:#FF6B35;font-size:1.2rem">₱{{ number_format($total, 2) }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
