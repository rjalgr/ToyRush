@extends('layouts.admin')
@section('title', $user->name)
@section('page-title', 'User Profile')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white mx-auto mb-3"
                     style="width:80px;height:80px;font-size:2rem;background:{{ $user->isAdmin() ? '#4F46E5' : '#FF6B35' }}">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-2">{{ $user->email }}</p>
                <span class="badge {{ $user->isAdmin() ? 'bg-primary' : 'bg-secondary' }}">{{ ucfirst($user->role) }}</span>
                <hr>
                <p class="small mb-1"><i class="bi bi-telephone me-2"></i>{{ $user->phone ?? '—' }}</p>
                <p class="small mb-1"><i class="bi bi-geo-alt me-2"></i>{{ $user->address ?? '—' }}</p>
                <p class="small mb-0 text-muted">Joined {{ $user->created_at->format('M d, Y') }}</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm flex-grow-1">Edit</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold">Order History ({{ $user->orders->count() }})</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Order #</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($user->orders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none fw-semibold">{{ $order->order_number }}</a></td>
                            <td>{{ $order->items->count() }} item(s)</td>
                            <td>₱{{ number_format($order->total, 2) }}</td>
                            <td><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                            <td class="small text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection