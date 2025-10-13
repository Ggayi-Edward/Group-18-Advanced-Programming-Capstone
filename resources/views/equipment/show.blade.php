@extends('layouts.app')

@section('title', 'Edit Equipment')
@section('page-title', 'Edit Equipment')

@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);
        color: #fff;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .btn-outline-light {
        border-color: #ecf0f1;
        color: #ecf0f1;
    }

    .btn-outline-light:hover {
        background-color: #ecf0f1;
        color: #2c3e50;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-3">
    <div class="card shadow-sm border-0">

        <!-- Header -->
        <div class="card-header card-header-gradient d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="fas fa-edit me-2"></i>Edit {{ $equipment->Name }}
            </h3>
            <a href="{{ route('equipment.index') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('equipment.update', $equipment->EquipmentId) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row g-4">

                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="Name" class="form-label">Equipment Name <span class="text-danger">*</span></label>
                            <input type="text" id="Name" name="Name"
                                   value="{{ old('Name', $equipment->Name) }}"
                                   class="form-control @error('Name') is-invalid @enderror"
                                   placeholder="Enter equipment name" required>
                            @error('Name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Capabilities" class="form-label">Capabilities</label>
                            <input type="text" id="Capabilities" name="Capabilities"
                                   value="{{ old('Capabilities', is_array($equipment->Capabilities) ? implode(', ', $equipment->Capabilities) : $equipment->Capabilities) }}"
                                   class="form-control @error('Capabilities') is-invalid @enderror"
                                   placeholder="Enter capabilities (comma-separated)">
                            @error('Capabilities')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Description" class="form-label">Description</label>
                            <textarea id="Description" name="Description" rows="3"
                                      class="form-control @error('Description') is-invalid @enderror"
                                      placeholder="Enter description">{{ old('Description', $equipment->Description) }}</textarea>
                            @error('Description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="InventoryCode" class="form-label">Inventory Code <span class="text-danger">*</span></label>
                            <input type="text" id="InventoryCode" name="InventoryCode"
                                   value="{{ old('InventoryCode', $equipment->InventoryCode) }}"
                                   class="form-control @error('InventoryCode') is-invalid @enderror"
                                   placeholder="Enter inventory code" required>
                            @error('InventoryCode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="FacilityId" class="form-label">Facility <span class="text-danger">*</span></label>
                            <select id="FacilityId" name="FacilityId" class="form-control @error('FacilityId') is-invalid @enderror" required>
                                <option value="">-- Select Facility --</option>
                                @foreach($facilities as $facility)
                                    <option value="{{ $facility->FacilityId }}"
                                        {{ old('FacilityId', $equipment->FacilityId) == $facility->FacilityId ? 'selected' : '' }}>
                                        {{ $facility->Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('FacilityId')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="UsageDomain" class="form-label">Usage Domain</label>
                            <input type="text" id="UsageDomain" name="UsageDomain"
                                   value="{{ old('UsageDomain', is_array($equipment->UsageDomain) ? implode(', ', $equipment->UsageDomain) : $equipment->UsageDomain) }}"
                                   class="form-control @error('UsageDomain') is-invalid @enderror"
                                   placeholder="e.g., Electronics, Mechanical, IoT">
                            @error('UsageDomain')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="SupportPhase" class="form-label">Support Phase</label>
                            <input type="text" id="SupportPhase" name="SupportPhase"
                                   value="{{ old('SupportPhase', is_array($equipment->SupportPhase) ? implode(', ', $equipment->SupportPhase) : $equipment->SupportPhase) }}"
                                   class="form-control @error('SupportPhase') is-invalid @enderror"
                                   placeholder="e.g., Training, Prototyping, Testing, Commercialization">
                            @error('SupportPhase')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Update Equipment
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
