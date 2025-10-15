@extends('layouts.app')

@section('title', 'Create Facility')
@section('page-title', 'Create Facility')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create Facility</h3>
    </div>
    <form action="{{ route('facilities.store') }}" method="POST">
        @csrf
        <div class="card-body">
            {{-- Facility Name --}}
            <div class="form-group">
                <label for="name">Facility Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" 
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Enter facility name"
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Location --}}
            <div class="form-group">
                <label for="location">Location <span class="text-danger">*</span></label>
                <input type="text" id="location" name="location" 
                       class="form-control @error('location') is-invalid @enderror"
                       placeholder="Enter location"
                       value="{{ old('location') }}" required>
                @error('location')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Facility Type --}}
            <div class="form-group">
                <label for="facilityType">Facility Type <span class="text-danger">*</span></label>
                <input type="text" id="facilityType" name="facilityType" 
                       class="form-control @error('facilityType') is-invalid @enderror"
                       placeholder="Lab, Hub, Innovation Center"
                       value="{{ old('facilityType') }}" required>
                @error('facilityType')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Partner Organization --}}
            <div class="form-group">
                <label for="partnerOrganization">Partner Organization</label>
                <input type="text" id="partnerOrganization" name="partnerOrganization" 
                       class="form-control"
                       placeholder="Enter partner organization"
                       value="{{ old('partnerOrganization') }}">
            </div>

            {{-- Capabilities --}}
            <div class="form-group">
                <label for="capabilities">Capabilities</label>
                <input type="text" id="capabilities" name="capabilities" 
                       class="form-control"
                       placeholder="IoT Lab, AI Research, Robotics"
                       value="{{ old('capabilities') }}">
                <small class="form-text text-muted">Separate multiple capabilities with commas</small>
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" 
                          class="form-control" rows="3"
                          placeholder="Enter facility description">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save
            </button>
            <a href="{{ route('facilities.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
