@extends('layouts.admin')
@section('title', $product->name)
@section('page-title', 'Product Details')
@section('content')
<div class="row g-4">

    {{-- Left: Image + Quick Upload --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center py-4">

                {{-- Image with camera overlay --}}
                <div class="position-relative d-inline-block mb-3">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             class="rounded shadow-sm"
                             style="width:200px;height:200px;object-fit:cover">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm"
                             style="width:200px;height:200px;font-size:4rem;margin:0 auto">🧸</div>
                    @endif
                    <label for="quickImageUpload"
                           class="position-absolute bottom-0 end-0 btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center"
                           style="width:36px;height:36px;cursor:pointer"
                           title="Upload Image">
                        <i class="bi bi-camera-fill" style="font-size:.85rem"></i>
                    </label>
                </div>

                {{-- Hidden upload form --}}
                <form method="POST"
                      action="{{ route('admin.products.update', $product) }}"
                      enctype="multipart/form-data"
                      id="imageUploadForm">
                    @csrf @method('PUT')
                    <input type="hidden" name="name"        value="{{ $product->name }}">
                    <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                    <input type="hidden" name="price"       value="{{ $product->price }}">
                    <input type="hidden" name="stock"       value="{{ $product->stock }}">
                    <input type="hidden" name="is_featured" value="{{ $product->is_featured ? 1 : 0 }}">
                    <input type="hidden" name="is_active"   value="{{ $product->is_active ? 1 : 0 }}">
                    <input type="file"
                           name="image"
                           id="quickImageUpload"
                           accept="image/*"
                           class="d-none"
                           onchange="document.getElementById('imageUploadForm').submit()">
                </form>

                <p class="text-muted mb-3" style="font-size:.75rem">
                    <i class="bi bi-camera me-1"></i>Click camera icon to {{ $product->image ? 'change' : 'upload' }} image
                </p>

                <h5 class="fw-bold mb-1">{{ $product->name }}</h5>
                <p class="text-muted small mb-2">{{ $product->category->name }}</p>

                <div class="d-flex justify-content-center gap-2 mb-3">
                    @if($product->is_featured)
                        <span class="badge" style="background:#FFD700;color:#333">Featured</span>
                    @endif
                    <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <a href="{{ route('admin.products.edit', $product) }}"
                   class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-pencil me-1"></i>Edit Product
                </a>
            </div>
        </div>
    </div>

    {{-- Right: Product Info + Order History --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold">Product Info</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted">SKU</small>
                        <p class="fw-semibold">{{ $product->sku }}</p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Price</small>
                        <p class="fw-semibold">
                            ₱{{ number_format($product->price, 2) }}
                            @if($product->sale_price)
                                <span class="text-danger ms-2">Sale: ₱{{ number_format($product->sale_price, 2) }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Stock</small>
                        <p class="fw-semibold">
                            <span class="badge {{ $product->stock <= 5 ? 'bg-danger' : 'bg-success' }}">
                                {{ $product->stock }} units
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Age Range</small>
                        <p class="fw-semibold">{{ $product->age_min ?? '?' }} - {{ $product->age_max ?? '?' }} years</p>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">Description</small>
                        <p class="mb-0">{{ $product->description ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold">Order History</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr><th>Order</th><th>Customer</th><th>Qty</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @forelse($product->orderItems as $item)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $item->order) }}">{{ $item->order->order_number }}</a></td>
                            <td>{{ $item->order->shipping_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection