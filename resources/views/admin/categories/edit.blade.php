@extends('layouts.admin')
@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="row"><div class="col-lg-6">
<div class="card">
    <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">Edit: {{ $category->name }}</h6></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <div class="mb-3">
                <label class="form-label fw-semibold">Category Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Image</label>
                @if($category->image)
                    <div class="mb-2"><img src="{{ asset('storage/'.$category->image) }}" class="rounded" style="height:60px;object-fit:cover"></div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection