@extends('layouts.admin')
@section('title', 'Products')
@section('page-title', 'Products')
@section('content')
<div class="card">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">All Products ({{ $products->total() }})</h6>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Add Product
        </a>
    </div>
    <div class="card-body border-bottom py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search by name or SKU..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width:60px"></th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    {{-- Thumbnail --}}
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="rounded"
                                 style="width:48px;height:48px;object-fit:cover">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                 style="width:48px;height:48px;font-size:1.4rem">🧸</div>
                        @endif
                    </td>

                    {{-- Name + SKU --}}
                    <td>
                        <p class="mb-0 fw-semibold small">{{ $product->name }}</p>
                        <span class="text-muted" style="font-size:.72rem">{{ $product->sku }}</span>
                    </td>

                    {{-- Category --}}
                    <td>
                        <span class="badge bg-light text-dark border">{{ $product->category->name }}</span>
                    </td>

                    {{-- Price --}}
                    <td>
                        @if($product->sale_price)
                            <span class="text-decoration-line-through text-muted small d-block">
                                ₱{{ number_format($product->price, 2) }}
                            </span>
                            <span class="fw-semibold text-danger">
                                ₱{{ number_format($product->sale_price, 2) }}
                            </span>
                        @else
                            <span class="fw-semibold">₱{{ number_format($product->price, 2) }}</span>
                        @endif
                    </td>

                    {{-- Stock --}}
                    <td>
                        <span class="badge {{ $product->stock <= 5 ? 'bg-danger' : ($product->stock <= 20 ? 'bg-warning text-dark' : 'bg-success') }}">
                            {{ $product->stock }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($product->is_featured)
                            <span class="badge me-1" style="background:#FFD700;color:#333">Featured</span>
                        @endif
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.products.show', $product) }}"
                               class="btn btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="btn btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($product->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="card-footer bg-white">
        {{ $products->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection