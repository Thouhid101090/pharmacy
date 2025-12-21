@extends('layouts.app')

@section('content')
<div class="container mt-3 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0 fw-bold text-dark">System Users</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus"></i> Add New User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm overflow-hidden">
        {{-- Desktop View --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-secondary small text-uppercase">
                        <th class="ps-3">ID</th>
                        <th>User Info</th>
                        <th>Role</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-3 text-muted">#{{ $user->id }}</td>
                        <td>
                            <div class="fw-bold">{{ $user->name }}</div>
                            <div class="small text-muted">{{ $user->email }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $user->role == 'superadmin' ? 'bg-danger' : 'bg-info text-dark' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary">Manage</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile View --}}
        <div class="d-md-none">
            @foreach($users as $user)
            <div class="p-3 border-bottom d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-person text-secondary fs-4"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                        <span class="badge {{ $user->role == 'superadmin' ? 'bg-danger' : 'bg-info text-dark' }} x-small" style="font-size: 0.65rem;">
                            {{ strtoupper($user->role) }}
                        </span>
                    </div>
                    <small class="text-muted d-block">{{ $user->email }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .container { padding-left: 12px; padding-right: 12px; }
        .x-small { padding: 4px 8px; }
    }
</style>
@endsection
