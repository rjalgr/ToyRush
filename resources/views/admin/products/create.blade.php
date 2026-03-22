@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Product' : 'Create Product')
@section('page-title', isset($product) ? 'Edit Product' : 'Add New Product')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold">{{ isset($product) ? 'Edit' : 'New' }} Product Details</h6>
            </div>
            <div class="card-body">
                <form method="POST"
                      action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @if(isset($product)) @method('PUT') @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">— Select Category —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Price (₱) <span class="text-danger">*</span></label>
                            <input type="number" name="price" step="0.01" min="0" class="form-control"
                                   value="{{ old('price', $product->price ?? '') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Sale Price (₱)</label>
                            <input type="number" name="sale_price" step="0.01" min="0" class="form-control"
                                   value="{{ old('sale_price', $product->sale_price ?? '') }}" placeholder="Optional">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="stock" min="0" class="form-control"
                                   value="{{ old('stock', $product->stock ?? 0) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Min Age (years)</label>
                            <input type="number" name="age_min" min="0" class="form-control"
                                   value="{{ old('age_min', $product->age_min ?? '') }}" placeholder="e.g. 3">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Max Age (years)</label>
                            <input type="number" name="age_max" min="0" class="form-control"
                                   value="{{ old('age_max', $product->age_max ?? '') }}" placeholder="e.g. 12">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="4"
                                      placeholder="Describe the product...">{{ old('description', $product->description ?? '') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Product Image</label>
                            @if(isset($product) && $product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$product->image) }}" class="rounded" style="height:80px;object-fit:cover">
                                    <small class="text-muted d-block">Current image — upload a new one to replace</small>
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                                       {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Mark as Featured</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                       {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active (visible in store)</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>{{ isset($product) ? 'Update Product' : 'Create Product' }}
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Tips</h6>
                <ul class="small text-muted ps-3">
                    <li class="mb-2">Set a sale price lower than the regular price to show a discount badge.</li>
                    <li class="mb-2">Age range helps parents filter toys for their children.</li>
                    <li class="mb-2">Featured products appear on the homepage hero section.</li>
                    <li>Stock ≤ 5 will show a "Low Stock" warning in the admin.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection