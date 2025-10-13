@extends('layouts.app')

@section('title', 'Add Equipment')
@section('page-title', 'Add Equipment')

@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);
        color: #fff;
    }

    .form-group label {
        font-weight: 500;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.15rem rgba(41, 128, 185, 0.25);
        border-color: #2980b9;
    }

    .btn-success {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #219150 0%, #28b463 100%);
    }

    .btn-outline-secondary:hover {
        background: #bdc3c7;
        color: #2c3e50;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-3">
    <div class="card shadow-sm border-0">
        <!-- Header -->
        <div class="card-header card-header-gradient d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-plus-circle me-2"></i> New Equipment</h3>
        </div>

        <!-- Form -->
        <form action="{{ route('equipment.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row g-3">
                    <!-- Left Column -->
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-3">
                            <label for="Name">Equipment Name <span class="text-danger">*</span></label>
                            <input type="text" id="Name" name="Name"
                                   value="{{ old('Name') }}"
                                   class="form-control @error('Name') is-invalid @enderror"
                                   placeholder="Enter equipment name" required>
                            @error('Name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Capabilities">Capabilities</label>
                            <input type="text" id="Capabilities" name="Capabilities"
                                   value="{{ old('Capabilities') }}"
                                   class="form-control @error('Capabilities') is-invalid @enderror"
                                   placeholder="e.g., 3D Printing, IoT Integration">
                            <small class="text-muted">Separate multiple capabilities with commas.</small>
                            @error('Capabilities')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Description">Description</label>
                            <textarea id="Description" name="Description" rows="3"
                                      class="form-control @error('Description') is-invalid @enderror"
                                      placeholder="Enter description">{{ old('Description') }}</textarea>
                            @error('Description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="InventoryCode">Inventory Code <span class="text-danger">*</span></label>
                            <input type="text" id="InventoryCode" name="InventoryCode"
                                   value="{{ old('InventoryCode') }}"
                                   class="form-control @error('InventoryCode') is-invalid @enderror"
                                   placeholder="Enter unique inventory code" required>
                            @error('InventoryCode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-3">
                            <label for="FacilityId">Facility <span class="text-danger">*</span></label>
                            <select id="FacilityId" name="FacilityId"
                                    class="form-control @error('FacilityId') is-invalid @enderror" required>
                                <option value="">-- Select Facility --</option>
                                @foreach($facilities as $facility)
                                    <option value="{{ $facility->FacilityId }}"
                                        {{ old('FacilityId') == $facility->FacilityId ? 'selected' : '' }}>
                                        {{ $facility->Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('FacilityId')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="UsageDomain">Usage Domain</label>
                            <input type="text" id="UsageDomain" name="UsageDomain"
                                   value="{{ old('UsageDomain') }}"
                                   class="form-control @error('UsageDomain') is-invalid @enderror"
                                   placeholder="e.g., Electronics, Mechanical, IoT">
                            @error('UsageDomain')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="SupportPhase">Support Phase</label>
                            <input type="text" id="SupportPhase" name="SupportPhase"
                                   value="{{ old('SupportPhase') }}"
                                   class="form-control @error('SupportPhase') is-invalid @enderror"
                                   placeholder="e.g., Training, Prototyping, Testing, Commercialization">
                            @error('SupportPhase')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Save Equipment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
