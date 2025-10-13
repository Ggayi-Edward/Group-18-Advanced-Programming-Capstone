@extends('layouts.app')

@section('title', 'Add Outcome')
@section('page-title', 'Add Outcome')

@section('styles')
<style>
    /* Gradient buttons */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: #fff;
        border: none;
    }
    .btn-gradient-success {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        color: #fff;
        border: none;
    }
    .btn-gradient-back {
        background: linear-gradient(135deg, #7f8c8d 0%, #95a5a6 100%);
        color: #fff;
        border: none;
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm border-0">

    <!-- Header with Gradient -->
    <div class="card-header text-white" style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <h3 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i> New Outcome
        </h3>
    </div>

    <!-- Form -->
<form action="{{ route('outcomes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Redirect URL: back to project details or index after saving --}}
    <input type="hidden" name="redirectTo" value="{{ $redirectUrl ?? route('outcomes.index') }}">

    <div class="card shadow-sm">
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
                                    {{ old('ProjectId') == $project->ProjectId ? 'selected' : '' }}>
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
                               value="{{ old('Type') }}"
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
                               value="{{ old('CertificationStatus') }}"
                               class="form-control"
                               placeholder="e.g., Pending, Certified">
                    </div>
                </div>

                <!-- Commercialization Status -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="Commercialization">Commercialization Status</label>
                        <input type="text" id="Commercialization" name="Commercialization"
                               value="{{ old('Commercialization') }}"
                               class="form-control"
                               placeholder="e.g., Idea, Pilot, Market">
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <!-- File Upload -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="FilePath">Artifact File</label>
                        <input type="file" id="FilePath" name="FilePath"
                               class="form-control @error('FilePath') is-invalid @enderror">
                        @error('FilePath')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="Description">Description</label>
                        <textarea id="Description" name="Description" rows="3"
                                  class="form-control"
                                  placeholder="Short description">{{ old('Description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ $redirectUrl ?? route('outcomes.index') }}" class="btn btn-outline-secondary">Back</a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Save Outcome
            </button>
        </div>
    </div>
</form>

</div>
@endsection
