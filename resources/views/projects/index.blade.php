@extends('layouts.app')

@section('title', 'Manage Projects')
@section('page-title', 'Manage Projects')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Projects</li>
@endsection

@section('styles')
<style>
    /* Compact table rows */
    .table-smaller th,
    .table-smaller td {
        padding: 0.35rem 0.5rem !important;
        vertical-align: middle !important;
        font-size: 0.85rem;
    }

    /* Flash messages */
    .alert {
        transition: opacity 0.5s ease-out;
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm border-0">

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success m-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger m-3">{{ session('error') }}</div>
    @endif

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center text-white"
         style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <div class="card-title mb-0">
            <i class="fas fa-tasks me-2"></i> All Projects
        </div>
        <div class="ml-auto">
            <a href="{{ route('projects.create') }}"
               class="btn btn-sm text-white"
               style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
                <i class="fas fa-plus"></i> Add Project
            </a>
        </div>
    </div>

    <!-- Body -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-smaller mb-0">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th style="width: 6%;">ID</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 20%;">Program</th>
                        <th style="width: 20%;">Facility</th>
                        <th style="width: 14%;">Status</th>
                        <th class="text-center" style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>{{ $project->ProjectId }}</td>
                            <td>{{ $project->Name }}</td>
                            <td>{{ $project->Program ? $project->Program->Name : 'N/A' }}</td>
                            <td>{{ $project->Facility ? $project->Facility->Name : 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $project->Status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('projects.show', $project->ProjectId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('projects.edit', $project->ProjectId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('projects.destroy', $project->ProjectId) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this project?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-xs text-white"
                                            style="background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Flash messages disappear after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500); // remove from DOM after fade
            });
        }, 3000);
    });
</script>
@endsection
