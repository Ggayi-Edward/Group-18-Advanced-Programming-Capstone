@extends('layouts.app')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service')

@section('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Gradient header for the card */
    .card-header-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);
        color: #fff;
    }

    /* Ensure Select2 matches Bootstrap form-control height */
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        height: auto;
        min-height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        list-style: none;
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header card-header-gradient">
        <h3 class="card-title">Edit {{ $service->Name }}</h3>
    </div>

    <form action="{{ route('services.update', $service->ServiceId) }}" method="POST">
        @csrf 
        @method('PUT')
        <div class="card-body">

            {{-- Service Name --}}
            <div class="form-group mb-3">
                <label for="name">Service Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $service->Name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $service->Description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category --}}
            <div class="form-group mb-3">
                <label for="category">Category <span class="text-danger">*</span></label>
                <input type="text" id="category" name="category" class="form-control @error('category') is-invalid @enderror"
                       value="{{ old('category', $service->Category) }}" required>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Skill Type --}}
            <div class="form-group mb-3">
                <label for="skillType">Skill Type <span class="text-danger">*</span></label>
                <input type="text" id="skillType" name="skillType" class="form-control @error('skillType') is-invalid @enderror"
                       value="{{ old('skillType', $service->SkillType) }}" required>
                @error('skillType')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Delivery Mode --}}
            <div class="form-group mb-3">
                <label for="deliveryMode">Delivery Mode</label>
                <input type="text" id="deliveryMode" name="deliveryMode" class="form-control @error('deliveryMode') is-invalid @enderror"
                       value="{{ old('deliveryMode', $service->DeliveryMode) }}">
                @error('deliveryMode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Target Groups --}}
            <div class="form-group mb-3">
                <label for="targetGroups">Target Groups (comma separated)</label>
                <input type="text" id="targetGroups" name="targetGroups"
                       class="form-control @error('targetGroups') is-invalid @enderror"
                       value="{{ old('targetGroups', implode(', ', $service->TargetGroups ?? [])) }}">
                @error('targetGroups')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Facility --}}
            <div class="form-group mb-3">
                <label for="facilityId">Facility <span class="text-danger">*</span></label>
                <select id="facilityId" name="facilityId"
                        class="form-select select2 @error('facilityId') is-invalid @enderror" required>
                    <option value="">-- Select Facility --</option>
                    @foreach($facilities as $facility)
                        <option value="{{ $facility->FacilityId }}"
                            {{ old('facilityId', $service->FacilityId) == $facility->FacilityId ? 'selected' : '' }}>
                            {{ $facility->Name }}
                        </option>
                    @endforeach
                </select>
                @error('facilityId')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">
                Update <i class="fas fa-save ms-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#facilityId').select2({
            placeholder: "Select a facility",
            width: '100%',
            allowClear: true
        });

        
    });
</script>
@endsection
