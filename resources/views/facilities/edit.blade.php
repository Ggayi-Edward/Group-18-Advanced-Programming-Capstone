@extends('layouts.app')

@section('title', 'Edit Facility')
@section('page-title', 'Edit Facility')

@section('content')
<div class="card shadow-sm border-0">
    <!-- Header with theme gradient -->
    <div class="card-header text-white"
         style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <h3 class="card-title mb-0">
            <i class="fas fa-edit me-2"></i> Edit Facility
        </h3>
    </div>

    <form action="{{ route('facilities.update', $facility->FacilityId) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <!-- Facility Name -->
            <div class="form-group mb-3">
                <label for="name">Facility Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name"
                       class="form-control"
                       value="{{ $facility->Name }}" required>
            </div>

            <!-- Location -->
            <div class="form-group mb-3">
                <label for="location">Location <span class="text-danger">*</span></label>
                <input type="text" id="location" name="location"
                       class="form-control"
                       value="{{ $facility->Location }}" required>
            </div>

            <!-- Facility Type -->
            <div class="form-group mb-3">
                <label for="facilityType">Facility Type <span class="text-danger">*</span></label>
                <input type="text" id="facilityType" name="facilityType"
                       class="form-control"
                       value="{{ $facility->FacilityType }}" required>
            </div>

            <!-- Partner Organization -->
            <div class="form-group mb-3">
                <label for="partnerOrganization">Partner Organization</label>
                <input type="text" id="partnerOrganization" name="partnerOrganization"
                       class="form-control"
                       value="{{ $facility->PartnerOrganization }}">
            </div>

            <!-- Capabilities -->
            <div class="form-group mb-3">
                <label for="capabilities">Capabilities</label>
                <input type="text" id="capabilities" name="capabilities"
                       class="form-control"
                       value="{{ implode(',', $facility->Capabilities) }}">
                <small class="form-text text-muted">Separate multiple capabilities with commas</small>
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          class="form-control" rows="3">{{ $facility->Description }}</textarea>
            </div>
        </div>

        <!-- Footer -->
        <div class="card-footer d-flex justify-content-between align-items-center">
            <!-- Cancel button on left -->
            <a href="{{ route('facilities.index') }}" class="btn btn-outline-secondary">
            </i> Cancel
            </a>

            <!-- Update button centered -->
            <div class="flex-grow-1 d-flex justify-content-center">
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>

            <!-- Empty div keeps layout balanced -->
            <div style="width: 100px;"></div>
        </div>
    </form>
</div>
@endsection
