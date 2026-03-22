@extends('layouts.app')
@section('title', 'Order Details')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Order Details</h2>
            <p class="text-muted mb-0">{{ $order->order_number }}</p>
        </div>
        <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Back</a>
    </div>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                @php $steps = ['pending','processing','shipped','delivered']; $current = array_search($order->status, $steps); @endphp
                @foreach($steps as $i => $step)
                <div class="text-center flex-grow-1">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:40px;height:40px;background:{{ ($order->status !== 'cancelled' && $i <= $current) ? '#FF6B35' : '#e9ecef' }};color:{{ ($order->status !== 'cancelled' && $i <= $current) ? '#fff' : '#aaa' }}">
                        @if($step==='pending')<i class="bi bi-clock"></i>
                        @elseif($step==='processing')<i class="bi bi-gear"></i>
                        @elseif($step==='shipped')<i class="bi bi-truck"></i>
                        @else<i class="bi bi-check-circle"></i>@endif
                    </div>
                    <p class="small mb-0 fw-semibold">{{ ucfirst($step) }}</p>
                </div>
                @if(!$loop->last)
                <div class="flex-grow-1" style="height:2px;background:{{ ($order->status !== 'cancelled' && $i < $current) ? '#FF6B35' : '#e9ecef' }};margin-top:-20px"></div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Order Items</h6></div>
                <div class="card-body p-0">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-semibold">{{ $item->product_name }}</p>
                            <p class="mb-0 small text-muted">₱{{ number_format($item->price, 2) }} x {{ $item->quantity }}</p>
                        </div>
                        <span class="fw-bold">₱{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between mb-1 small"><span class="text-muted">Subtotal</span><span>₱{{ number_format($order->subtotal, 2) }}</span></div>
                    <div class="d-flex justify-content-between mb-1 small"><span class="text-muted">Shipping</span><span>{{ $order->shipping == 0 ? 'FREE' : '₱'.number_format($order->shipping, 2) }}</span></div>
                    <div class="d-flex justify-content-between mb-2 small"><span class="text-muted">Tax (12%)</span><span>₱{{ number_format($order->tax, 2) }}</span></div>
                    <div class="d-flex justify-content-between fw-bold"><span>Total</span><span style="color:#FF6B35">₱{{ number_format($order->total, 2) }}</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Shipping Address</h6></div>
                <div class="card-body small">
                    <p class="fw-semibold mb-1">{{ $order->shipping_name }}</p>
                    <p class="mb-1">{{ $order->shipping_address }}</p>
                    <p class="mb-1">{{ $order->shipping_city }}{{ $order->shipping_state ? ', '.$order->shipping_state : '' }}</p>
                    <p class="mb-0 text-muted">{{ $order->shipping_email }}</p>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Payment Info</h6></div>
                <div class="card-body small">
                    <p class="mb-1"><span class="fw-semibold">Method:</span> {{ strtoupper($order->payment_method) }}</p>
                    <p class="mb-1"><span class="fw-semibold">Status:</span>
                        <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($order->payment_status) }}</span>
                    </p>
                    <p class="mb-0"><span class="fw-semibold">Date:</span> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
