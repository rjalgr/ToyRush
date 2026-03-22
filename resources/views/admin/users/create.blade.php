@extends('layouts.admin')
@section('title', 'Add User')
@section('page-title', 'Add User')

@section('content')
<div class="row"><div class="col-lg-6">
<div class="card">
    <div class="card-header bg-white border-0 py-3"><h6 class="mb-0 fw-bold">New User</h6></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password *</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Role *</label>
                <select name="role" class="form-select" required>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Create User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection