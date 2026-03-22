@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)
@section('page-title', 'Order Details')

@section('content')
<div class="row g-4">
    {{-- Order Items --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between">
                <h6 class="mb-0 fw-bold">{{ $order->order_number }}</h6>
                <span class="badge bg-{{ $order->status_badge }} fs-6">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 align-middle">
                    <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <p class="mb-0 fw-semibold">{{ $item->product_name }}</p>
                                <small class="text-muted">{{ $item->product->sku ?? '' }}</small>
                            </td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="fw-semibold">₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr><td colspan="3" class="text-end">Subtotal</td><td>₱{{ number_format($order->subtotal, 2) }}</td></tr>
                        <tr><td colspan="3" class="text-end">Shipping</td><td>₱{{ number_format($order->shipping, 2) }}</td></tr>
                        <tr><td colspan="3" class="text-end">Tax (12%)</td><td>₱{{ number_format($order->tax, 2) }}</td></tr>
                        <tr><td colspan="3" class="text-end fw-bold">Total</td><td class="fw-bold text-primary">₱{{ number_format($order->total, 2) }}</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="card">
            <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Update Order Status</h6></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="row g-3 align-items-end">
                    @csrf @method('PUT')
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Order Status</label>
                        <select name="status" class="form-select">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            @foreach(['pending','paid','failed','refunded'] as $s)
                                <option value="{{ $s }}" {{ $order->payment_status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar Info --}}
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Customer</h6></div>
            <div class="card-body">
                <p class="mb-1 fw-semibold">{{ $order->user->name }}</p>
                <p class="mb-1 small text-muted">{{ $order->user->email }}</p>
                <p class="mb-0 small text-muted">{{ $order->user->phone }}</p>
                <hr>
                <p class="mb-0 small"><span class="fw-semibold">Payment:</span> {{ strtoupper($order->payment_method) }}</p>
                <p class="mb-0 small"><span class="fw-semibold">Date:</span> {{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Shipping Address</h6></div>
            <div class="card-body">
                <p class="mb-1 fw-semibold">{{ $order->shipping_name }}</p>
                <p class="mb-1 small">{{ $order->shipping_address }}</p>
                <p class="mb-1 small">{{ $order->shipping_city }}{{ $order->shipping_state ? ', '.$order->shipping_state : '' }}</p>
                <p class="mb-1 small">{{ $order->shipping_country }} {{ $order->shipping_zip }}</p>
                <p class="mb-0 small text-muted">{{ $order->shipping_email }}</p>
                @if($order->notes)
                    <hr>
                    <p class="small mb-0"><span class="fw-semibold">Note:</span> {{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection