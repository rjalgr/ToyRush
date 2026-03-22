@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
<div class="card">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">All Orders ({{ $orders->total() }})</h6>
    </div>
    <div class="card-body border-bottom py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Order # or customer name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="fw-semibold text-decoration-none">{{ $order->order_number }}</a></td>
                    <td>
                        <p class="mb-0 small fw-semibold">{{ $order->user->name }}</p>
                        <p class="mb-0 text-muted" style="font-size:.75rem">{{ $order->shipping_city }}</p>
                    </td>
                    <td class="fw-semibold">₱{{ number_format($order->total, 2) }}</td>
                    <td>
                        <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : ($order->payment_status === 'failed' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="small text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Delete this order?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-5">No orders found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white">{{ $orders->withQueryString()->links() }}</div>
    @endif
</div>
@endsection