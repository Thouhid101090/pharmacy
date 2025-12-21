@extends('layouts.app')

@section('content')
<div class="container mt-3 pb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 mb-0 fw-bold text-dark">User Management</h2>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
                    View All Users
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger shadow-sm border-0 animate__animated animate__shakeX">
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus me-2"></i>Add New User</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-secondary small">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name" required value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-secondary small">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com" required value="{{ old('email') }}">
                        </div>

                        <div class="row g-2">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold text-secondary small">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold text-secondary small">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label fw-bold text-secondary small">Access Level</label>
                            <select name="role" class="form-select" required>
                                <option value="">Select Role</option>
                                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin (Full Access)</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Standard Access)</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                Create User Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center mt-3 text-muted small">
                Users will be able to log in immediately after their account is created.
            </p>
        </div>
    </div>
</div>

<style>
    /* Mobile optimization */
    @media (max-width: 767.98px) {
        .card-body { padding: 1.5rem; }
        .form-control, .form-select {
            padding: 0.75rem; /* Larger touch area for fingers */
        }
    }
</style>
@endsection
