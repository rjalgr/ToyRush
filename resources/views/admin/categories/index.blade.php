@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div class="card">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">All Categories ({{ $categories->total() }})</h6>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Category</a>
    </div>
    <div class="card-body border-bottom py-2">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search categories..." value="{{ request('search') }}" style="max-width:300px">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead><tr><th>Name</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td class="fw-semibold">{{ $cat->name }}</td>
                    <td><code>{{ $cat->slug }}</code></td>
                    <td><span class="badge bg-info">{{ $cat->products_count }}</span></td>
                    <td><span class="badge {{ $cat->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $cat->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-5">No categories found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-white">{{ $categories->links() }}</div>
    @endif
</div>
@endsection