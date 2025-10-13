@extends('layouts.app')

@section('title', 'Edit Project')
@section('page-title', 'Edit Project')

@section('styles')
<style>
    /* Gradient header for the card */
    .card-header-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header card-header-gradient">
        <h3 class="card-title mb-0">
            <i class="fas fa-edit me-2"></i> Edit {{ $project->Name }}
        </h3>
    </div>

    <form action="{{ route('projects.update', $project->ProjectId) }}" method="POST">
        @csrf 
        @method('PUT')

        <div class="card-body">
            <!-- Project Name -->
            <div class="form-group mb-3">
                <label for="name">Project Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $project->Name) }}"
                       class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Program -->
            <div class="form-group mb-3">
                <label for="programId">Program <span class="text-danger">*</span></label>
                <select id="programId" name="programId"
                        class="form-control @error('programId') is-invalid @enderror" required>
                    @foreach($programs as $program)
                        <option value="{{ $program->ProgramId }}"
                            {{ old('programId', $project->ProgramId) == $program->ProgramId ? 'selected' : '' }}>
                            {{ $program->Name }}
                        </option>
                    @endforeach
                </select>
                @error('programId')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Facility -->
            <div class="form-group mb-3">
                <label for="facilityId">Facility <span class="text-danger">*</span></label>
                <select id="facilityId" name="facilityId"
                        class="form-control @error('facilityId') is-invalid @enderror" required>
                    @foreach($facilities as $facility)
                        <option value="{{ $facility->FacilityId }}"
                            {{ old('facilityId', $project->FacilityId) == $facility->FacilityId ? 'selected' : '' }}>
                            {{ $facility->Name }}
                        </option>
                    @endforeach
                </select>
                @error('facilityId')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status -->
            <div class="form-group mb-3">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select id="status" name="status"
                        class="form-control @error('status') is-invalid @enderror" required>
                    <option value="Planned"   {{ old('status', $project->Status) == 'Planned' ? 'selected' : '' }}>Planned</option>
                    <option value="Ongoing"   {{ old('status', $project->Status) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="Completed" {{ old('status', $project->Status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          rows="3"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Brief description">{{ old('description', $project->Description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Participants -->
            <div class="form-group mb-3">
                <label for="participants">Participants / Team Members <span class="text-danger">*</span></label>
                <input type="text" id="participants" name="participants"
                       value="{{ old('participants', is_array($project->Participants) ? implode(', ', $project->Participants) : $project->Participants) }}"
                       class="form-control @error('participants') is-invalid @enderror"
                       placeholder="Enter participants (comma-separated)" required>
                <small class="text-muted">Example: Jane Doe, John Smith</small>
                @error('participants')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Outcomes -->
            <div class="form-group mb-3">
                <label for="outcomes">Outcomes (comma-separated)</label>
                <input type="text" id="outcomes" name="outcomes"
                       value="{{ old('outcomes', is_array($project->Outcomes) ? implode(', ', $project->Outcomes) : $project->Outcomes) }}"
                       class="form-control @error('outcomes') is-invalid @enderror"
                       placeholder="Enter outcomes">
                @error('outcomes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Technical Requirements -->
            <div class="form-group mb-3">
                <label for="requirements">Technical Requirements (comma-separated)</label>
                <input type="text" id="requirements" name="requirements"
                       value="{{ old('requirements', is_array($project->Requirements) ? implode(', ', $project->Requirements) : $project->Requirements) }}"
                       class="form-control @error('requirements') is-invalid @enderror"
                       placeholder="Enter requirements">
                @error('requirements')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <!-- Footer -->
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Update Project
            </button>
        </div>
    </form>
</div>
@endsection
