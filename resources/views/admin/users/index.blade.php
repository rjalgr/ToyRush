@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Users')

@section('content')
<div class="card">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">All Users ({{ $users->total() }})</h6>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add User</a>
    </div>
    <div class="card-body border-bottom py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Name or email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select form-select-sm">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Orders</th><th>Joined</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                 style="width:36px;height:36px;background:{{ $user->isAdmin() ? '#4F46E5' : '#FF6B35' }};flex-shrink:0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="fw-semibold small">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="small">{{ $user->email }}</td>
                    <td><span class="badge {{ $user->isAdmin() ? 'bg-primary' : 'bg-secondary' }}">{{ ucfirst($user->role) }}</span></td>
                    <td><span class="badge bg-light text-dark">{{ $user->orders_count }}</span></td>
                    <td class="small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">No users found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white">{{ $users->withQueryString()->links() }}</div>
    @endif
</div>
@endsection