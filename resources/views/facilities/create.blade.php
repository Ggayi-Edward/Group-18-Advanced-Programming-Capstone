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
            <div class="form-group">
                <label for="name">Facility Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter facility name" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" class="form-control" placeholder="Enter location" required>
            </div>
            <div class="form-group">
                <label for="facilityType">Facility Type</label>
                <input type="text" id="facilityType" name="facilityType" class="form-control" placeholder="Lab, Hub, Innovation Center" required>
            </div>
            <div class="form-group">
                <label for="partnerOrganization">Partner Organization</label>
                <input type="text" id="partnerOrganization" name="partnerOrganization" class="form-control" placeholder="Enter partner organization">
            </div>
            <div class="form-group">
                <label for="capabilities">Capabilities</label>
                <input type="text" id="capabilities" name="capabilities" class="form-control" placeholder="IoT Lab, AI Research, Robotics">
                <small class="form-text text-muted">Separate multiple capabilities with commas</small>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter facility description"></textarea>
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
