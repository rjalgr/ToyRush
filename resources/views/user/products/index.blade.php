@extends('layouts.app')
@section('title', 'Shop')
@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm sticky-top" style="top:80px">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Filter Products</h6>
                    <form method="GET" action="{{ route('user.shop') }}">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Search</label>
                            <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Search toys...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Category</label>
                            @foreach($categories as $cat)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="{{ $cat->slug }}" id="cat-{{ $cat->id }}" {{ request('category') === $cat->slug ? 'checked' : '' }}>
                                <label class="form-check-label small" for="cat-{{ $cat->id }}">{{ $cat->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Price Range (₱)</label>
                            <div class="row g-1">
                                <div class="col-6"><input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ request('min_price') }}"></div>
                                <div class="col-6"><input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ request('max_price') }}"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Sort By</label>
                            <select name="sort" class="form-select form-select-sm">
                                <option value="latest" {{ request('sort','latest') === 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name A-Z</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filters</button>
                        <a href="{{ route('user.shop') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">Clear</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="text-muted mb-0">Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products</p>
            </div>
            @if($products->count())
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-6 col-md-4">
                    @include('user.products._card', compact('product'))
                </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $products->links() }}</div>
            @else
            <div class="text-center py-5">
                <div style="font-size:4rem">🔍</div>
                <h5 class="mt-3">No products found</h5>
                <p class="text-muted">Try adjusting your filters</p>
                <a href="{{ route('user.shop') }}" class="btn btn-primary">Clear Filters</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
