@extends('layouts.app')

@section('title', 'Create Program')
@section('page-title', 'Create Program')

@section('styles')
<style>
    /* Gradient header for the card */
    .card-header-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);
        color: #fff;
    }
</style>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <!-- Header -->
    <div class="card-header card-header-gradient">
        <h3 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i> New Program
        </h3>
    </div>

    <form action="{{ route('programs.store') }}" method="POST">
        @csrf
        <div class="card-body">

            <!-- Program Name -->
            <div class="form-group mb-3">
                <label for="Name">Program Name <span class="text-danger">*</span></label>
                <input type="text" id="Name" name="Name"
                       value="{{ old('Name') }}"
                       class="form-control @error('Name') is-invalid @enderror"
                       placeholder="Enter program name" required>
                @error('Name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="Description">Description</label>
                <textarea id="Description" name="Description"
                          class="form-control @error('Description') is-invalid @enderror"
                          rows="3"
                          placeholder="Brief description of the program">{{ old('Description') }}</textarea>
                @error('Description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- National Alignment (Single-Select) -->
            <div class="form-group mb-3">
                <label for="NationalAlignment">National Alignment</label>
                <select id="NationalAlignment" name="NationalAlignment"
                        class="form-select select2 @error('NationalAlignment') is-invalid @enderror">
                    <option value="" disabled selected>Select an alignment</option>
                    @php
                        $recognizedAlignments = ['NDPIII', 'Digital Roadmap', '4IR Strategy', 'SDGs'];
                        $oldAlignment = old('NationalAlignment');
                    @endphp
                    @foreach($recognizedAlignments as $alignment)
                        <option value="{{ $alignment }}" {{ $oldAlignment == $alignment ? 'selected' : '' }}>
                            {{ $alignment }}
                        </option>
                    @endforeach
                </select>
                @error('NationalAlignment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Focus Areas -->
            <div class="form-group mb-3">
                <label for="FocusAreas">Focus Areas</label>
                <input type="text" id="FocusAreas" name="FocusAreas"
                       value="{{ old('FocusAreas') }}"
                       class="form-control @error('FocusAreas') is-invalid @enderror"
                       placeholder="e.g., IoT, Automation, Renewable Energy">
                <small class="form-text text-muted">Separate multiple focus areas with commas</small>
                @error('FocusAreas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phases -->
            <div class="form-group mb-3">
                <label for="Phases">Phases</label>
                <input type="text" id="Phases" name="Phases"
                       value="{{ old('Phases') }}"
                       class="form-control @error('Phases') is-invalid @enderror"
                       placeholder="e.g., Cross-Skilling, Collaboration, Prototyping">
                <small class="form-text text-muted">Separate multiple phases with commas</small>
                @error('Phases')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <!-- Footer -->
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary">Back</a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save
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
        $('#NationalAlignment').select2({
            placeholder: "Select an alignment",
            width: '100%',
            allowClear: true
        });
    });
</script>
@endsection
