@extends('layouts.app')

@section('title', 'Add Participant')
@section('page-title', 'Add Participant')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">New Participant</h3>
        <a href="{{ route('participants.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>

    <form action="{{ route('participants.store') }}" method="POST">
        @csrf
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Full Name -->
                <div class="form-group mb-3">
                    <label for="fullName">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="fullName" id="fullName"
                           class="form-control" value="{{ old('fullName', $participant->FullName ?? '') }}" required>
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
    <label for="email">Email <span class="text-danger">*</span></label>
    <input type="email" name="email" id="email"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $participant->Email ?? '') }}" required>
    @error('email')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                <!-- Affiliation -->
                <div class="form-group mb-3">
                    <label for="affiliation">Affiliation</label>
                    <select name="affiliation" id="affiliation" class="form-control">
                        @foreach(['CS','SE','Engineering','Other'] as $option)
                            <option value="{{ $option }}" {{ old('affiliation', $participant->Affiliation ?? '') == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Specialization -->
                <div class="form-group mb-3">
                    <label for="specialization">Specialization</label>
                    <select name="specialization" id="specialization" class="form-control">
                        @foreach(['Software','Hardware','Business'] as $option)
                            <option value="{{ $option }}" {{ old('specialization', $participant->Specialization ?? '') == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

              
                <!-- Cross Skill Trained -->
                <div class="form-group mb-3">
                    <label>Cross Skill Trained</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="crossSkillTrained" id="crossSkillYes" value="1"
                            {{ old('crossSkillTrained', $participant->crossSkillTrained ?? null) == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="CrossSkillYes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="crossSkillTrained" id="crossSkillNo" value="0"
                            {{ old('crossSkillTrained', $participant->CrossSkillTrained ?? null) == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="CrossSkillNo">No</label>
                    </div>
                </div>


                <!-- Institution -->
                <div class="form-group mb-3">
                    <label for="institution">Institution</label>
                    <select name="institution" id="institution" class="form-control">
                        @foreach(['SCIT','CEDAT','UniPod','UIRI','Lwera'] as $option)
                            <option value="{{ $option }}" {{ old('institution', $participant->Institution ?? '') == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Project -->
                <div class="form-group mb-3">
                    <label for="projectId">Project <span class="text-danger">*</span></label>
                    <select id="projectId" name="projectId"
                            class="form-control @error('projectId') is-invalid @enderror" required>
                        <option value="">-- Select Project --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->ProjectId }}" {{ old('projectId') == $project->ProjectId ? 'selected' : '' }}>
                                {{ $project->Name }}
                            </option>
                        @endforeach
                    </select>
                    @error('projectId')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center gap-2">
    <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i> Save
    </button>
    
</div>

        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
@endsection
