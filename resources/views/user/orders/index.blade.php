@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">My Orders</h2>
    @if($orders->isEmpty())
    <div class="text-center py-5">
        <h4 class="mt-3">No orders yet</h4>
        <p class="text-muted">Start shopping and your orders will appear here.</p>
        <a href="{{ route('user.shop') }}" class="btn btn-primary">Shop Now</a>
    </div>
    @else
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @foreach($orders as $order)
            <div class="p-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                    <div>
                        <h6 class="fw-bold mb-1">{{ $order->order_number }}</h6>
                        <p class="text-muted small mb-0">{{ $order->created_at->format('F d, Y') }} · {{ $order->items->count() }} item(s)</p>
                    </div>
                    <div class="text-end">
                        <p class="fw-bold mb-1" style="color:#FF6B35">₱{{ number_format($order->total, 2) }}</p>
                        <span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach($order->items->take(3) as $item)
                            <span class="badge bg-light text-dark small">{{ $item->product_name }}</span>
                        @endforeach
                        @if($order->items->count() > 3)
                            <span class="badge bg-light text-dark small">+{{ $order->items->count() - 3 }} more</span>
                        @endif
                    </div>
                    <a href="{{ route('user.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
