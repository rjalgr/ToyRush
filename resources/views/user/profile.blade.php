@extends('layouts.app')
@section('title', 'My Profile')
@section('content')

<div class="container py-4 py-md-5">
    <h2 class="fw-bold mb-4"> My Profile</h2>

    <div class="row g-4">

        {{-- ── Left Column ── --}}
        <div class="col-12 col-lg-4">

            {{-- Profile Card --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body text-center py-4 px-3">

                    {{-- Avatar --}}
                    <div class="rounded-circle d-flex align-items-center justify-content-center
                                fw-bold text-white mx-auto mb-3"
                         style="width:88px;height:88px;font-size:2rem;background:#FF6B35;flex-shrink:0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-2">{{ $user->email }}</p>
                    <span class="badge rounded-pill px-3 py-1" style="background:#FF6B35">
                        {{ ucfirst($user->role) }}
                    </span>

                    <hr class="my-3">

                    {{-- Info rows --}}
                    <div class="text-start">
                        @php
                            $info = [
                                ['icon' => 'person-fill',    'label' => 'Full Name',    'value' => $user->name],
                                ['icon' => 'envelope-fill',  'label' => 'Email',        'value' => $user->email],
                                ['icon' => 'telephone-fill', 'label' => 'Phone',        'value' => $user->phone ?? '—'],
                                ['icon' => 'geo-alt-fill',   'label' => 'Address',      'value' => $user->address ?? '—'],
                                ['icon' => 'calendar-fill',  'label' => 'Member Since', 'value' => $user->created_at->format('F d, Y')],
                            ];
                        @endphp

                        @foreach($info as $row)
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <i class="bi bi-{{ $row['icon'] }} mt-1" style="color:#FF6B35;min-width:16px;font-size:.95rem"></i>
                            <div class="overflow-hidden">
                                <p class="text-muted mb-0" style="font-size:.72rem;line-height:1.2">{{ $row['label'] }}</p>
                                <p class="fw-semibold mb-0 small text-truncate">{{ $row['value'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="card border-0 shadow-sm rounded-3 mt-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-1">
                    <h6 class="fw-bold mb-0">My Stats</h6>
                </div>
                <div class="card-body">
                    @php
                        $stats = [
                            ['icon' => 'bag-fill',          'color' => '#FF6B35',  'label' => 'Total Orders', 'badge' => 'style="background:#FF6B35"',      'value' => $user->orders()->count()],
                            ['icon' => 'check-circle-fill', 'color' => '#198754',  'label' => 'Completed',    'badge' => 'class="badge bg-success"',         'value' => $user->orders()->where('status','delivered')->count()],
                            ['icon' => 'hourglass-split',   'color' => '#ffc107',  'label' => 'Pending',      'badge' => 'class="badge bg-warning text-dark"','value' => $user->orders()->where('status','pending')->count()],
                        ];
                    @endphp

                    @foreach($stats as $s)
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-{{ $s['icon'] }}" style="color:{{ $s['color'] }}"></i>
                            <span class="small">{{ $s['label'] }}</span>
                        </div>
                        <span class="badge px-2 py-1" {!! $s['badge'] !!}>{{ $s['value'] }}</span>
                    </div>
                    @endforeach

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cash-stack text-success"></i>
                            <span class="small">Total Spent</span>
                        </div>
                        <span class="fw-bold small" style="color:#FF6B35">
                            ₱{{ number_format($user->orders()->where('payment_status','paid')->sum('total'), 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Right Column ── --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-transparent border-0 py-3
                            d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Recent Orders</h6>
                    <a href="{{ route('user.orders.index') }}"
                       class="btn btn-outline-primary btn-sm">View All</a>
                </div>

                <div class="card-body p-0">
                    @forelse($recentOrders as $order)
                    <div class="p-3 p-md-4 {{ !$loop->last ? 'border-bottom' : '' }}">

                        {{-- Order header --}}
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                            <div>
                                <h6 class="fw-bold mb-1 small">{{ $order->order_number }}</h6>
                                <p class="text-muted mb-0" style="font-size:.8rem">
                                    <i class="bi bi-calendar me-1"></i>{{ $order->created_at->format('M d, Y') }}
                                    &nbsp;·&nbsp;
                                    <i class="bi bi-box me-1"></i>{{ $order->items->count() }} item(s)
                                </p>
                            </div>
                            <div class="text-end">
                                <p class="fw-bold mb-1 small" style="color:#FF6B35">
                                    ₱{{ number_format($order->total, 2) }}
                                </p>
                                <span class="badge bg-{{ $order->status_badge }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        {{-- Order items + action --}}
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 gap-2">
                            <div class="d-flex gap-1 flex-wrap">
                                @foreach($order->items->take(3) as $item)
                                    <span class="badge bg-light text-dark border" style="font-size:.72rem">
                                        {{ $item->product_name }}
                                    </span>
                                @endforeach
                                @if($order->items->count() > 3)
                                    <span class="badge bg-light text-dark border" style="font-size:.72rem">
                                        +{{ $order->items->count() - 3 }} more
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('user.orders.show', $order) }}"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>View
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 px-3">
                        <div style="font-size:3rem"></div>
                        <h6 class="mt-3 fw-semibold">No orders yet</h6>
                        <p class="text-muted small mb-3">Start shopping and your orders will appear here.</p>
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