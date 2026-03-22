@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')
<div class="row g-4 mb-4">
    @php
        $cards = [
            ['label'=>'Total Users',    'value'=>number_format($stats['total_users']),   'icon'=>'people-fill',       'c1'=>'#667eea','c2'=>'#764ba2'],
            ['label'=>'Products',       'value'=>number_format($stats['total_products']),'icon'=>'box-seam-fill',     'c1'=>'#f093fb','c2'=>'#f5576c'],
            ['label'=>'Total Orders',   'value'=>number_format($stats['total_orders']),  'icon'=>'bag-check-fill',    'c1'=>'#4facfe','c2'=>'#00f2fe'],
            ['label'=>'Revenue (Paid)', 'value'=>'₱'.number_format($stats['total_revenue'],2),'icon'=>'cash-stack',  'c1'=>'#3e5e4a','c2'=>'#a2bdb8'],
            ['label'=>'Pending Orders', 'value'=>number_format($stats['pending_orders']),'icon'=>'hourglass-split',  'c1'=>'#fa709a','c2'=>'#fee140'],
            ['label'=>'Low Stock',      'value'=>number_format($stats['low_stock']),     'icon'=>'exclamation-circle','c1'=>'#a18cd1','c2'=>'#fbc2eb'],
        ];
    @endphp
    @foreach($cards as $card)
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card" style="--c1:{{ $card['c1'] }};--c2:{{ $card['c2'] }}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="small mb-1 opacity-75">{{ $card['label'] }}</p>
                    <h4 class="mb-0 fw-bold">{{ $card['value'] }}</h4>
                </div>
                <i class="bi bi-{{ $card['icon'] }} fs-3 opacity-75"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold">Recent Orders</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none fw-semibold">{{ $order->order_number }}</a></td>
                            <td>{{ $order->user->name }}</td>
                            <td>₱{{ number_format($order->total, 2) }}</td>
                            <td><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold">Top Selling Products</h6>
            </div>
            <div class="card-body">
                @forelse($topProducts as $i => $product)
                <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                    <span class="badge rounded-pill me-3" style="background:#4F46E5;min-width:26px">{{ $i + 1 }}</span>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-semibold small">{{ $product->name }}</p>
                        <p class="mb-0 text-muted" style="font-size:.75rem">₱{{ number_format($product->price, 2) }}</p>
                    </div>
                    <span class="badge bg-light text-dark">{{ $product->order_items_count }} sold</span>
                </div>
                @empty
                <p class="text-muted text-center">No sales data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
