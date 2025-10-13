@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('styles')
<style>
    .card-dashboard {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.25s ease-in-out;
        overflow: hidden;
    }
    .card-dashboard:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }
    .card-dashboard .card-body h3 {
        font-weight: 700;
        font-size: 1.75rem;
        margin: 0;
    }
    .card-dashboard .card-body p {
        margin: 0;
        font-size: 0.95rem;
        opacity: 0.9;
    }
    .card-dashboard .icon {
        opacity: 0.85;
    }
    .card-dashboard .card-footer {
        background: rgba(0,0,0,0.15);
        border-top: none;
        font-size: 0.9rem;
        transition: background 0.2s ease-in-out;
    }
    .card-dashboard .card-footer:hover {
        background: rgba(0,0,0,0.25);
    }
</style>
@endsection

@section('content')
<div class="row g-3">
    <!-- Programs -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-dashboard" style="background: linear-gradient(135deg, var(--accent-blue) 0%, #2980b9 100%); color: var(--text-white);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ count(\App\Data\FakeProgramRepository::all()) }}</h3>
                    <p>Programs</p>
                </div>
                <div class="icon"><i class="fas fa-project-diagram fa-3x"></i></div>
            </div>
            <a href="{{ route('programs.index') }}" class="card-footer text-white text-decoration-none">
                Manage Programs <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Projects -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-dashboard" style="background: linear-gradient(135deg, var(--accent-success) 0%, #219a52 100%); color: var(--text-white);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ count(\App\Data\FakeProjectRepository::all()) }}</h3>
                    <p>Projects</p>
                </div>
                <div class="icon"><i class="fas fa-tasks fa-3x"></i></div>
            </div>
            <a href="{{ route('projects.index') }}" class="card-footer text-white text-decoration-none">
                Manage Projects <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Facilities -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-dashboard" style="background: linear-gradient(135deg, var(--accent-info) 0%, #16a085 100%); color: var(--text-white);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ count(\App\Data\FakeFacilityRepository::all()) }}</h3>
                    <p>Facilities</p>
                </div>
                <div class="icon"><i class="fas fa-building fa-3x"></i></div>
            </div>
            <a href="{{ route('facilities.index') }}" class="card-footer text-white text-decoration-none">
                Manage Facilities <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Services -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-dashboard" style="background: linear-gradient(135deg, #8e44ad 0%, #9b59b6 100%); color: var(--text-white);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ count(\App\Data\FakeServiceRepository::all()) }}</h3>
                    <p>Services</p>
                </div>
                <div class="icon"><i class="fas fa-cogs fa-3x"></i></div>
            </div>
            <a href="{{ route('services.index') }}" class="card-footer text-white text-decoration-none">
                Manage Services <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Equipment -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-dashboard" style="background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%); color: var(--text-white);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ count(\App\Data\FakeEquipmentRepository::all()) }}</h3>
                    <p>Equipment</p>
                </div>
                <div class="icon"><i class="fas fa-tools fa-3x"></i></div>
            </div>
            <a href="{{ route('equipment.index') }}" class="card-footer text-white text-decoration-none">
                Manage Equipment <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Participants -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-dashboard" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: var(--text-white);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ count(\App\Data\FakeParticipantRepository::all()) }}</h3>
                    <p>Participants</p>
                </div>
                <div class="icon"><i class="fas fa-users fa-3x"></i></div>
            </div>
            <a href="{{ route('participants.index') }}" class="card-footer text-white text-decoration-none">
                Manage Participants <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Outcomes -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-dashboard" style="background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); color: var(--text-white);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ count(\App\Data\FakeOutcomeRepository::all()) }}</h3>
                    <p>Outcomes</p>
                </div>
                <div class="icon"><i class="fas fa-chart-line fa-3x"></i></div>
            </div>
            <a href="{{ route('outcomes.index') }}" class="card-footer text-white text-decoration-none">
                Manage Outcomes <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection
