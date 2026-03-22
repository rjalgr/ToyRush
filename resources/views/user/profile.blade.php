@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="container py-5" style="min-height: calc(100vh - 250px);">
    <h2 class="fw-bold mb-4">My Profile</h2>
    <div class="row g-4">

        {{-- Left Column --}}
        <div class="col-lg-4">

            {{-- Profile Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white mx-auto mb-3"
                         style="width:90px;height:90px;font-size:2.2rem;background:var(--toy-primary,#FF6B35)">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-2">{{ $user->email }}</p>
                    <span class="badge px-3 py-1" style="background:#FF6B35;border-radius:20px">
                        {{ ucfirst($user->role) }}
                    </span>
                    <hr class="my-3">
                    <div class="text-start px-2">
                        <div class="mb-3 d-flex align-items-start gap-2">
                            <i class="bi bi-person-fill mt-1" style="color:#FF6B35;min-width:18px"></i>
                            <div>
                                <p class="text-muted mb-0" style="font-size:.75rem">Full Name</p>
                                <p class="fw-semibold mb-0 small">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="mb-3 d-flex align-items-start gap-2">
                            <i class="bi bi-envelope-fill mt-1" style="color:#FF6B35;min-width:18px"></i>
                            <div>
                                <p class="text-muted mb-0" style="font-size:.75rem">Email</p>
                                <p class="fw-semibold mb-0 small">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="mb-3 d-flex align-items-start gap-2">
                            <i class="bi bi-telephone-fill mt-1" style="color:#FF6B35;min-width:18px"></i>
                            <div>
                                <p class="text-muted mb-0" style="font-size:.75rem">Phone</p>
                                <p class="fw-semibold mb-0 small">{{ $user->phone ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="mb-3 d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt-fill mt-1" style="color:#FF6B35;min-width:18px"></i>
                            <div>
                                <p class="text-muted mb-0" style="font-size:.75rem">Address</p>
                                <p class="fw-semibold mb-0 small">{{ $user->address ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-calendar-fill mt-1" style="color:#FF6B35;min-width:18px"></i>
                            <div>
                                <p class="text-muted mb-0" style="font-size:.75rem">Member Since</p>
                                <p class="fw-semibold mb-0 small">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0 pt-3 pb-2">
                    <h6 class="fw-bold mb-0">My Stats</h6>
                </div>
                <div class="card-body pt-2">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-bag-fill" style="color:#FF6B35"></i>
                            <span class="small">Total Orders</span>
                        </div>
                        <span class="badge px-2 py-1" style="background:#FF6B35">{{ $user->orders()->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span class="small">Completed</span>
                        </div>
                        <span class="badge bg-success px-2 py-1">{{ $user->orders()->where('status', 'delivered')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-hourglass-split text-warning"></i>
                            <span class="small">Pending</span>
                        </div>
                        <span class="badge bg-warning text-dark px-2 py-1">{{ $user->orders()->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cash-stack text-success"></i>
                            <span class="small">Total Spent</span>
                        </div>
                        <span class="fw-bold small" style="color:#FF6B35">
                            ₱{{ number_format($user->orders()->where('payment_status', 'paid')->sum('total'), 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">🕐 Recent Orders</h6>
                    <a href="{{ route('user.orders.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <div class="card-body p-0">
                    @forelse($recentOrders as $order)
                    <div class="p-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $order->order_number }}</h6>
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-calendar me-1"></i>{{ $order->created_at->format('F d, Y') }}
                                    &nbsp;·&nbsp;
                                    <i class="bi bi-box me-1"></i>{{ $order->items->count() }} item(s)
                                </p>
                            </div>
                            <div class="text-end">
                                <p class="fw-bold mb-1" style="color:#FF6B35">₱{{ number_format($order->total, 2) }}</p>
                                <span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($order->items->take(3) as $item)
                                    <span class="badge bg-light text-dark small border">{{ $item->product_name }}</span>
                                @endforeach
                                @if($order->items->count() > 3)
                                    <span class="badge bg-light text-dark small border">+{{ $order->items->count() - 3 }} more</span>
                                @endif
                            </div>
                            <a href="{{ route('user.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                       <h6 class="mt-3 fw-semibold">No orders yet</h6>
                        <p class="text-muted small">Start shopping and your orders will appear here.</p>
                        <a href="{{ route('user.shop') }}" class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-bag me-1"></i>Shop Now
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection