@extends('layouts.app')

@section('title', 'Edit Outcome')
@section('page-title', 'Edit Outcome')

@section('content')
<div class="card shadow-sm border-0">

    <!-- Header with Gradient -->
    @section('styles')
    <style>
        /* Gradient header for the card */
        .card-header-gradient {
            background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);
            color: #fff;
        }
    </style>
@endsection
    <!-- Form -->

<form action="{{ route('outcomes.update', $outcome->OutcomeId) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="redirectTo" value="{{ $redirectUrl }}">

    <div class="card-body">

        <div class="row g-3">
            <!-- Project Selection -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="ProjectId">Program / Project <span class="text-danger">*</span></label>
                    <select id="ProjectId" name="ProjectId" 
                            class="form-control @error('ProjectId') is-invalid @enderror" required>
                        <option value="">-- Select Project --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->ProjectId }}" 
                                {{ old('ProjectId', $outcome->ProjectId) == $project->ProjectId ? 'selected' : '' }}>
                                {{ $project->Name }}
                            </option>
                        @endforeach
                    </select>
                    @error('ProjectId')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Outcome Type -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Type">Outcome Type <span class="text-danger">*</span></label>
                    <input type="text" id="Type" name="Type"
                           value="{{ old('Type', $outcome->Type) }}"
                           class="form-control @error('Type') is-invalid @enderror"
                           placeholder="e.g., Prototype, CAD, Report" required>
                    @error('Type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Certification Status -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="CertificationStatus">Certification Status</label>
                    <input type="text" id="CertificationStatus" name="CertificationStatus"
                           value="{{ old('CertificationStatus', $outcome->CertificationStatus) }}"
                           class="form-control"
                           placeholder="e.g., Pending, Certified">
                </div>
            </div>

            <!-- Commercialization Status -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Commercialization">Commercialization Status</label>
                    <input type="text" id="Commercialization" name="Commercialization"
                           value="{{ old('Commercialization', $outcome->Commercialization) }}"
                           class="form-control"
                           placeholder="e.g., Idea, Pilot, Market">
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- File Path -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="FilePath">Artifact link</label>
                    <input type="text" id="FilePath" name="FilePath"
                           value="{{ old('FilePath', $outcome->FilePath) }}"
                           class="form-control"
                           placeholder="Enter file URL or path">
                </div>
            </div>

            <!-- Description -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Description">Description</label>
                    <textarea id="Description" name="Description" rows="3"
                              class="form-control"
                              placeholder="Short description">{{ old('Description', $outcome->Description) }}</textarea>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer Buttons -->
    <div class="card-footer d-flex justify-content-between">
        <!-- Back button goes to $redirectUrl -->
        <a href="{{ $redirectUrl }}" class="btn btn-outline-secondary">Back</a>

        <!-- Update button submits the form and then controller uses redirectTo -->
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Update Outcome
        </button>
    </div>
</form>


</div>
@endsection
