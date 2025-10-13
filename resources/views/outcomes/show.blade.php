@extends('layouts.app')

@section('title', 'Outcome Details')
@section('page-title', 'Outcome Details')

@section('styles')
@vite('resources/css/program-details.css')
<link href="{{ asset('css/program-details.css') }}" rel="stylesheet">
<style>
    /* Tiny square icon buttons */
    .icon-square.btn {
        width: 28px;
        height: 28px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Compact table and card rows */
    .table td, .table th, .card-body > div {
        padding: .35rem .5rem;
    }

    /* Gradient headers */
    .card-header-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-3">

    <!-- Header with Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Overview</h3>
        <a href="{{ $redirectUrl }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>

    <!-- Top Info Cards -->
    <div class="row g-3 mb-4">
        <!-- Outcome Info Card -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header card-header-gradient">
                    <h5 class="mb-0">Outcome Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="text-muted small">Type</div>
                        <div>{{ $outcome->Type }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">Certification Status</div>
                        <div>{{ $outcome->CertificationStatus ?: 'N/A' }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">Commercialization Status</div>
                        <div>{{ $outcome->Commercialization ?: 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Card -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header card-header-gradient">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <div>{{ $outcome->Description ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Artifact Section -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0">Artifact</h4>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @if(!empty($outcome->FilePath))
                <a href="{{ asset($outcome->FilePath) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-download me-1"></i> Download Artifact
                </a>
            @else
                <span class="text-muted">No file uploaded</span>
            @endif
        </div>
    </div>

</div>
@endsection
