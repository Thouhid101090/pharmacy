@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h2 class="h4 mb-3 fw-bold">Medicine Stock</h2>

        @if (session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('stocks.search') }}" method="GET" class="mb-4">
            <div class="input-group shadow-sm">
                <input type="text" name="query" class="form-control" placeholder="Search medicine name..."
                    aria-label="Search">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </form>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Medicine Name</th>
                            <th class="text-center">Quantity</th>
                            <th>Supplier</th>
                            <th>Expiry Status</th>
                            {{-- <th class="text-end pe-3">Action</th> --}}
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stocks as $stock)
                            @php
                                $isLowStock = $stock->quantity <= 5;
                                $isExpired =
                                    $stock->expiry_date && \Carbon\Carbon::parse($stock->expiry_date)->isPast();
                            @endphp
                            <tr class="{{ $isLowStock ? 'table-danger' : '' }}">
                                <td class="ps-3 text-muted small">{{ $stock->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $stock->medicine->name }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $isLowStock ? 'bg-danger' : 'bg-light text-dark border' }} fs-6">
                                        {{ $stock->quantity }}
                                    </span>
                                </td>
                                <td>{{ $stock->medicine->company_name }}</td>
                                <td>
                                    @if ($isExpired)
                                        <span class="badge bg-danger">Expired</span>
                                        <div class="small text-danger">{{ $stock->expiry_date }}</div>
                                    @else
                                        <span class="text-muted">{{ $stock->expiry_date ?? '-' }}</span>
                                    @endif
                                </td>
                                {{-- <td class="text-end pe-3">
                                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this stock record? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash">Delete</i>
                                        </button>
                                    </form>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No stock items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-md-none">
                @forelse($stocks as $stock)
                    @php
                        $isLowStock = $stock->quantity <= 5;
                        $isExpired = $stock->expiry_date && \Carbon\Carbon::parse($stock->expiry_date)->isPast();
                    @endphp
                    <div class="p-3 border-bottom {{ $isLowStock ? 'bg-light-danger' : '' }}"
                        style="{{ $isLowStock ? 'border-left: 5px solid #dc3545;' : '' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $stock->medicine->name }}</h6>
                                <small class="text-muted d-block">Supplier: {{ $stock->medicine->company_name }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge {{ $isLowStock ? 'bg-danger' : 'bg-success' }} fs-6">
                                    {{ $stock->quantity }} in stock
                                </span>
                            </div>
                        </div>

                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <small class="text-muted">ID: #{{ $stock->id }}</small>
                            <div>
                                @if ($isExpired)
                                    <span class="badge bg-danger">Expired ({{ $stock->expiry_date }})</span>
                                @else
                                    <small class="text-secondary">Exp: {{ $stock->expiry_date ?? '-' }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">No stock available</div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        /* Custom light red background for low stock rows on mobile */
        .bg-light-danger {
            background-color: #fff8f8;
        }

        @media (max-width: 767.98px) {
            .container {
                padding-left: 12px;
                padding-right: 12px;
            }

            .input-group {
                max-width: 100% !important;
            }
        }
    </style>
@endsection
