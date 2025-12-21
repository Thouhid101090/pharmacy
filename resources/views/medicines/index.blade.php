@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 fw-bold">Medicines</h2>
        <a href="{{ route('medicines.create') }}" class="btn btn-primary shadow-sm fw-bold">
            <i class="bi bi-plus-lg"></i> + Add New
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <form action="{{ route('medicines.search') }}" method="GET" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" name="query" class="form-control" placeholder="Search by name or company..." aria-label="Search">
            <button type="submit" class="btn btn-primary px-4">Search</button>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-secondary small text-uppercase">
                        <th class="ps-3">ID</th>
                        <th>Medicine Name</th>
                        <th>Company Name</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicines as $medicine)
                    <tr>
                        <td class="ps-3 text-muted">{{ $medicine->id }}</td>
                        <td class="fw-bold">{{ $medicine->name }}</td>
                        <td>{{ $medicine->company_name }}</td>
                        <td class="text-end pe-3">
                            <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-outline-warning px-3">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-md-none">
            @forelse($medicines as $medicine)
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">ID #{{ $medicine->id }}</small>
                        <h6 class="mb-1 fw-bold">{{ $medicine->name }}</h6>
                        <p class="mb-0 text-secondary small">
                            <i class="bi bi-building"></i> {{ $medicine->company_name }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-warning shadow-sm">
                            Edit
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-muted">No medicines found.</div>
            @endforelse
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $medicines->links() }}
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .container { padding-left: 12px; padding-right: 12px; }
        .input-group { width: 100% !important; }
        .btn-primary { width: auto; }
    }
</style>
@endsection
