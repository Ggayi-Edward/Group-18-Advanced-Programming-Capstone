@extends('layouts.app')

@section('title', 'Create Project')
@section('page-title', 'Create Project')

@section('content')
<div class="card shadow-sm border-0">
    <!-- Header with Gradient -->
    <div class="card-header text-white" style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <h3 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i> New Project
        </h3>
    </div>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <!-- Project Name -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name">Project Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Enter project name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select id="status" name="status"
                                class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">-- Select Status --</option>
                            <option value="Planned" {{ old('status') == 'Planned' ? 'selected' : '' }}>Planned</option>
                            <option value="Ongoing" {{ old('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Program -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="programId">Program <span class="text-danger">*</span></label>
                        @if(!empty($programs) && count($programs))
                            <select id="programId" name="programId"
                                    class="form-control @error('programId') is-invalid @enderror" required>
                                <option value="">-- Select Program --</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->ProgramId }}"
                                        {{ (old('programId') == $program->ProgramId) || (isset($preselectedProgramId) && $preselectedProgramId == $program->ProgramId) ? 'selected' : '' }}>
                                        {{ $program->Name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control" disabled>
                                <option>No programs available — create a program first</option>
                            </select>
                        @endif
                        @error('programId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Facility -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="facilityId">Facility <span class="text-danger">*</span></label>
                        @if(!empty($facilities) && count($facilities))
                            <select id="facilityId" name="facilityId"
                                    class="form-control @error('facilityId') is-invalid @enderror" required>
                                <option value="">-- Select Facility --</option>
                                @foreach($facilities as $facility)
                                    <option value="{{ $facility->FacilityId }}"
                                        {{ (old('facilityId') == $facility->FacilityId) || (isset($preselectedFacilityId) && $preselectedFacilityId == $facility->FacilityId) ? 'selected' : '' }}>
                                        {{ $facility->Name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control" disabled>
                                <option>No facilities available — create a facility first</option>
                            </select>
                        @endif
                        @error('facilityId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="3"
                          placeholder="Brief description of the project">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Participants (Team Members) -->
            <div class="form-group mb-3">
                <label for="participants">Participants / Team Members <span class="text-danger">*</span></label>
                <input type="text" id="participants" name="participants"
                       value="{{ old('participants') }}"
                       class="form-control @error('participants') is-invalid @enderror"
                       placeholder="Enter team members (comma-separated)" required>
                <small class="text-muted">Example: Jane Doe, John Smith, Dr. Amina</small>
                @error('participants')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Outcomes -->
            <div class="form-group mb-3">
                <label for="outcomes">Outcomes (comma-separated)</label>
                <input type="text" id="outcomes" name="outcomes"
                       value="{{ old('outcomes') }}"
                       class="form-control @error('outcomes') is-invalid @enderror"
                       placeholder="Enter outcomes, e.g., Successful prototype, Safety approved">
                @error('outcomes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Requirements -->
            <div class="form-group mb-3">
                <label for="requirements">Technical Requirements (comma-separated)</label>
                <input type="text" id="requirements" name="requirements"
                       value="{{ old('requirements') }}"
                       class="form-control @error('requirements') is-invalid @enderror"
                       placeholder="Enter technical requirements, e.g., Calibration, Safety checks">
                @error('requirements')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Footer -->
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                Back
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save Project
            </button>
        </div>
    </form>
</div>
@endsection
