@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="container py-5" style="min-height: calc(100vh - 250px);">
    <h2 class="fw-bold mb-4">My Profile</h2>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white mx-auto mb-3"
                         style="width:80px;height:80px;font-size:2rem;background:#FF6B35">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>
                    <span class="badge" style="background:#FF6B35">{{ ucfirst($user->role) }}</span>
                    <hr>
                    <div class="text-start">
                        <div class="mb-3">
                            <p class="text-muted small mb-1"><i class="bi bi-person me-2"></i>Full Name</p>
                            <p class="fw-semibold mb-0">{{ $user->name }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted small mb-1"><i class="bi bi-envelope me-2"></i>Email</p>
                            <p class="fw-semibold mb-0">{{ $user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted small mb-1"><i class="bi bi-telephone me-2"></i>Phone</p>
                            <p class="fw-semibold mb-0">{{ $user->phone ?? '—' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted small mb-1"><i class="bi bi-geo-alt me-2"></i>Address</p>
                            <p class="fw-semibold mb-0">{{ $user->address ?? '—' }}</p>
                        </div>
                        <div class="mb-0">
                            <p class="text-muted small mb-1"><i class="bi bi-calendar me-2"></i>Member Since</p>
                            <p class="fw-semibold mb-0">{{ $user->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">My Stats</h6>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <span class="text-muted small">Total Orders</span>
                        <span class="badge" style="background:#FF6B35">{{ $user->orders()->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <span class="text-muted small">Completed</span>
                        <span class="badge bg-success">{{ $user->orders()->where('status', 'delivered')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <span class="text-muted small">Pending</span>
                        <span class="badge bg-warning text-dark">{{ $user->orders()->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Total Spent</span>
                        <span class="fw-bold" style="color:#FF6B35">₱{{ number_format($user->orders()->where('payment_status', 'paid')->sum('total'), 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Recent Orders</h6>
                    <a href="{{ route('user.orders.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <div class="card-body p-0">
                    @forelse($recentOrders as $order)
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
                    @empty
                    <div class="text-center py-5">
                        <div style="font-size:3rem">📦</div>
                        <p class="text-muted mt-2">No orders yet. Start shopping!</p>
                        <a href="{{ route('user.shop') }}" class="btn btn-primary btn-sm">Shop Now</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
