@extends('layouts.app')

@section('title', 'Manage Facilities')
@section('page-title', 'Manage Facilities')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Facilities</li>
@endsection

@section('styles')
<style>
    .table-smaller th,
    .table-smaller td {
        padding: 0.3rem 0.45rem !important;
        vertical-align: middle !important;
        font-size: 0.82rem;
    }

    /* Slim filter controls */
    .filter-form .form-control,
    .filter-form .form-select,
    .filter-form .btn {
        height: 32px;
        font-size: 0.8rem;
        padding: 0.2rem 0.45rem;
    }

    /* Search with icon inside (icon at the end) */
    .search-wrapper {
        position: relative;
    }

    .search-wrapper .search-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        cursor: pointer;
        padding: 0;
    }
    .search-wrapper .search-btn i {
        font-size: 0.8rem;
        color: #888;
    }

    .search-wrapper .fa-search {
        position: absolute;
        right: 10px; /* moved to right */
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.8rem;
        color: #888;
    }
    .search-wrapper input {
        padding-right: 28px; /* space for the icon */
        padding-left: 0.45rem; /* normal padding */
    }

    /* Extra spacing between Reset & Apply buttons */
    .filter-form .btn + .btn {
        margin-left: 8px;
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm border-0">

    <!-- Filter Bar -->
    <div class="card-body pb-2">
        <form method="GET" action="{{ route('facilities.index') }}" class="filter-form">
            <div class="row g-2 align-items-center">

                <!-- Search -->
                <div class="search-wrapper">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="form-control" placeholder="Search by name">

                    <!-- Turn icon into a button -->
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>


                <!-- Type -->
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="Workshop" {{ request('type')=='Workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="Testing Center" {{ request('type')=='Testing Center' ? 'selected' : '' }}>Testing Center</option>
                        <option value="Laboratory" {{ request('type')=='Lab' ? 'selected' : '' }}>Laboratory</option>
                    </select>
                </div>

                <!-- Partner -->
                <div class="col-md-3">
                    <input type="text" name="partner" value="{{ request('partner') }}" 
                           class="form-control" placeholder="Partner org">
                </div>

                <!-- Capabilities -->
                <div class="col-md-2">
                    <input type="text" name="capabilities" value="{{ request('capabilities') }}" 
                           class="form-control" placeholder="Capabilities">
                </div>

                <!-- Buttons -->
                <div class="col-md-2 d-flex justify-content-end">
                    <a href="{{ route('facilities.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Card Header -->
    <div class="card-header d-flex justify-content-between align-items-center text-white"
         style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <div class="card-title mb-0">
            <i class="fas fa-hospital-alt mr-2"></i> All Facilities
        </div>
        <div class="ml-auto">
            <a href="{{ route('facilities.create') }}"
               class="btn btn-sm text-white"
               style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
                <i class="fas fa-plus"></i> Add Facility
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-smaller mb-0">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 25%;">Name</th>
                        <th style="width: 30%;">Location</th>
                        <th style="width: 15%;">Type</th>
                        <th class="text-center" style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $facility)
                        <tr>
                            <td>{{ $facility->FacilityId }}</td>
                            <td>{{ $facility->Name }}</td>
                            <td>{{ $facility->Location }}</td>
                            <td>{{ $facility->FacilityType }}</td>
                            <td class="text-center">
                                <a href="{{ route('facilities.show', $facility->FacilityId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('facilities.edit', $facility->FacilityId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('facilities.destroy', $facility->FacilityId) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this facility?');">
                                    @csrf
                                    @method('DELETE')
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
                            <td colspan="5" class="text-center text-muted">No facilities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
