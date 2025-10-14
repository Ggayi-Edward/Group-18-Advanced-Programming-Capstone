@extends('layouts.app')

@section('title', isset($service) ? 'Edit Service' : 'Add Service')
@section('page-title', isset($service) ? 'Edit Service' : 'Add Service')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header text-white" style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <h3 class="card-title mb-0">
            <i class="fas fa-{{ isset($service) ? 'edit' : 'plus-circle' }} me-2"></i>
            {{ isset($service) ? 'Edit Service' : 'New Service' }}
        </h3>
    </div>

    <form action="{{ isset($service) ? route('services.update', $service->ServiceId) : route('services.store') }}" method="POST">
        @csrf
        @if(isset($service))
            @method('PUT')
        @endif

        <div class="card-body">

            <!-- Name -->
            <div class="form-group mb-3">
                <label for="name">Service Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $service->Name ?? '') }}"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Enter service name" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="form-group mb-3">
                <label for="category">Category <span class="text-danger">*</span></label>
                <input type="text" id="category" name="category"
                       value="{{ old('category', $service->Category ?? '') }}"
                       class="form-control @error('category') is-invalid @enderror"
                       placeholder="e.g., Health, Education, ICT" required>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Skill Type -->
            <div class="form-group mb-3">
                <label for="skillType">Skill Type <span class="text-danger">*</span></label>
                <input type="text" id="skillType" name="skillType"
                       value="{{ old('skillType', $service->SkillType ?? '') }}"
                       class="form-control @error('skillType') is-invalid @enderror"
                       placeholder="Enter skill type" required>
                @error('skillType')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Facility -->
            <div class="form-group mb-3">
                <label for="facilityId">Facility <span class="text-danger">*</span></label>
                <select id="facilityId" name="facilityId"
                        class="form-control @error('facilityId') is-invalid @enderror" required>
                    <option value="">-- Select Facility --</option>
                    @foreach($facilities as $facility)
                        <option value="{{ $facility->FacilityId }}"
                            {{ old('facilityId', $service->FacilityId ?? '') == $facility->FacilityId ? 'selected' : '' }}>
                            {{ $facility->Name }}
                        </option>
                    @endforeach
                </select>
                @error('facilityId')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Delivery Mode -->
            <div class="form-group mb-3">
                <label for="deliveryMode">Delivery Mode</label>
                <input type="text" id="deliveryMode" name="deliveryMode"
                       value="{{ old('deliveryMode', $service->DeliveryMode ?? '') }}"
                       class="form-control @error('deliveryMode') is-invalid @enderror"
                       placeholder="e.g., Online, Onsite, Hybrid">
                @error('deliveryMode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Target Groups -->
            <div class="form-group mb-3">
                <label for="targetGroups">Target Groups</label>
                <input type="text" id="targetGroups" name="targetGroups"
                       value="{{ old('targetGroups', isset($service->TargetGroups) ? implode(',', $service->TargetGroups) : '') }}"
                       class="form-control @error('targetGroups') is-invalid @enderror"
                       placeholder="e.g., Students, Teachers, Administrators">
                <small class="form-text text-muted">Separate multiple groups with commas</small>
                @error('targetGroups')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="3"
                          placeholder="Brief description of the service">{{ old('description', $service->Description ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">Back</a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> {{ isset($service) ? 'Update' : 'Save' }}
            </button>
        </div>
    </form>
</div>
@endsection
