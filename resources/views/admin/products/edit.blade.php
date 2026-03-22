@extends('layouts.admin')
@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold">Edit Product: {{ $product->name }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Product Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category *</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Price (₱) *</label>
                            <input type="number" name="price" step="0.01" min="0" class="form-control" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Sale Price (₱)</label>
                            <input type="number" name="sale_price" step="0.01" min="0" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Stock *</label>
                            <input type="number" name="stock" min="0" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Min Age</label>
                            <input type="number" name="age_min" min="0" class="form-control" value="{{ old('age_min', $product->age_min) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Max Age</label>
                            <input type="number" name="age_max" min="0" class="form-control" value="{{ old('age_max', $product->age_max) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Product Image</label>
                            @if($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$product->image) }}" class="rounded" style="height:80px;object-fit:cover">
                                    <small class="text-muted d-block mt-1">Upload new image to replace</small>
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                                       {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Mark as Featured</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                       {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update Product</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white py-2">
                <h6 class="mb-0">Danger Zone</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted">Permanently delete this product. This action cannot be undone.</p>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to delete {{ $product->name }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100"><i class="bi bi-trash me-1"></i>Delete Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection