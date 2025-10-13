@extends('layouts.app')

@section('title', 'Edit Program')
@section('page-title', 'Edit Program')

@section('styles')
<style>
    /* Gradient header for the card */
    .card-header-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);
        color: #fff;
    }

    /* Adjust Select2 to match Bootstrap form-control height */
    .select2-container--default .select2-selection--single {
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
    }
</style>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <!-- Header -->
    <div class="card-header card-header-gradient">
        <h3 class="card-title mb-0">Edit {{ $program->Name }}</h3>
    </div>

    <form action="{{ route('programs.update', $program->ProgramId) }}" method="POST">
        @csrf 
        @method('PUT')
        <div class="card-body">

            <!-- Program Name -->
            <div class="form-group mb-3">
                <label for="Name">Program Name <span class="text-danger">*</span></label>
                <input type="text" id="Name" name="Name" 
                       value="{{ old('Name', $program->Name) }}"
                       class="form-control @error('Name') is-invalid @enderror" required>
                @error('Name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="Description">Description</label>
                <textarea id="Description" name="Description" 
                          class="form-control @error('Description') is-invalid @enderror" 
                          rows="3">{{ old('Description', $program->Description) }}</textarea>
                @error('Description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- National Alignment (Select2 Single-Select) -->
            <div class="form-group mb-3">
                <label for="NationalAlignment">National Alignment</label>
                <select id="NationalAlignment" name="NationalAlignment" 
                        class="form-select select2 @error('NationalAlignment') is-invalid @enderror">
                    <option value="" disabled selected>Select an alignment</option>
                    @php
                        $recognizedAlignments = ['NDPIII', 'Digital Roadmap', '4IR Strategy', 'SDGs'];
                        $selectedAlignment = old('NationalAlignment', $program->NationalAlignment);
                    @endphp
                    @foreach($recognizedAlignments as $alignment)
                        <option value="{{ $alignment }}" {{ $selectedAlignment == $alignment ? 'selected' : '' }}>
                            {{ $alignment }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Select one alignment.</small>
                @error('NationalAlignment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Focus Areas -->
            <div class="form-group mb-3">
                <label for="FocusAreas">Focus Areas</label>
                <input type="text" id="FocusAreas" name="FocusAreas"
                       value="{{ old('FocusAreas', is_array($program->FocusAreas) ? implode(',', $program->FocusAreas) : $program->FocusAreas) }}"
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
                       value="{{ old('Phases', is_array($program->Phases) ? implode(',', $program->Phases) : $program->Phases) }}"
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
            <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
        $('#NationalAlignment').select2({
            placeholder: "Select an alignment",
            width: '100%',
            allowClear: true
        });
    });
</script>
@endsection
