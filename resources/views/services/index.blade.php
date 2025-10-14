@extends('layouts.app')

@section('title', 'Manage Services')
@section('page-title', 'Manage Services')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Services</li>
@endsection

@section('styles')
<style>
    /* top toolbar */
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .75rem;
        margin-bottom: .5rem;
    }
    /* search */
    .search-wrapper {
        position: relative;
        width: 100%;
        max-width: 360px;
    }
    .search-wrapper input {
        padding-right: 2rem;         /* room for icon */
        height: 34px;                /* same height as small buttons */
        font-size: 0.9rem;
    }
    .search-wrapper button {
        position: absolute;
        top: 50%;
        right: .5rem;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        padding: 0;
        line-height: 1;
        color: #6c757d;
        cursor: pointer;
    }

    /* smaller table rows */
    .table-smaller th,
    .table-smaller td {
        padding: .35rem .5rem !important;
        font-size: .85rem;
        vertical-align: middle !important;
    }
</style>
@endsection

@section('content')

<!-- Toolbar ABOVE the card -->
<div class="toolbar">
    <form action="{{ route('services.index') }}" method="GET" class="mb-0 w-100" style="max-width: 360px;">
        <div class="search-wrapper">
            <input type="text"
                   name="category"
                   class="form-control form-control-sm"
                   placeholder="Search by category..."
                   value="{{ $category ?? request('category') }}">
            <button type="submit" aria-label="Search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <a href="{{ route('services.create') }}"
       class="btn btn-sm text-white"
       style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
        <i class="fas fa-plus"></i> Add Service
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center text-white"
         style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <div class="card-title mb-0">
            <i class="fas fa-concierge-bell mr-2"></i> All Services
        </div>
        <!-- (intentionally empty; toolbar above handles search/add) -->
        <div></div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-smaller mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Delivery Mode</th>
                        <th class="text-center" style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service->ServiceId }}</td>
                            <td>{{ $service->Name }}</td>
                            <td>{{ $service->Category }}</td>
                            <td>{{ $service->DeliveryMode }}</td>
                            <td class="text-center">
                                <a href="{{ route('services.show', $service->ServiceId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('services.edit', $service->ServiceId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('services.destroy', $service->ServiceId) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this service?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-xs text-white"
                                            style="background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No services found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
