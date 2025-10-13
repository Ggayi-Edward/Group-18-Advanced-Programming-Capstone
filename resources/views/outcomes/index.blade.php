@extends('layouts.app')

@section('title', 'Manage Outcomes')
@section('page-title', 'Manage Outcomes')

@section('breadcrumb')
    <li class="breadcrumb-item active">Outcomes</li>
@endsection

@section('styles')
<style>
    /* Make table rows smaller */
    .table-smaller th,
    .table-smaller td {
        padding: 0.35rem 0.5rem !important; /* reduce padding */
        vertical-align: middle !important; /* center content */
        font-size: 0.85rem; /* slightly smaller text */
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center text-white"
         style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <div class="card-title mb-0">
            <i class="fas fa-clipboard-list mr-2"></i> All Outcomes
        </div>
        <div class="ml-auto">
            <a href="{{ route('outcomes.create') }}"
               class="btn btn-sm text-white"
               style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
                <i class="fas fa-plus"></i> Add Outcome
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-smaller mb-0">
                <thead style="background-color: #f8f9fa;">
    <tr>
        <th style="width: 6%;">ID</th>
        <th style="width: 12%;">Project</th>
        <th style="width: 20%;">Type</th>
        <th style="width: 20%;">Certification Status</th>
        <th style="width: 20%;">Commercialization</th>
        <th class="text-center" style="width: 22%;">Actions</th>
    </tr>
</thead>
<tbody>
    @php
        $projects = \App\Data\FakeProjectRepository::all(); // Fetch projects
    @endphp
    @forelse($outcomes as $outcome)
        @php
            $projectName = $projects[$outcome->ProjectId]->Name ?? '-';
        @endphp
        <tr>
            <td>{{ $outcome->OutcomeId }}</td>
            <td>{{ $projectName }}</td>
            <td>{{ $outcome->Type }}</td>
            <td>{{ $outcome->CertificationStatus ?? '-' }}</td>
            <td>{{ $outcome->Commercialization ?? '-' }}</td>
            <td class="text-center">
                <!-- Show -->
                <a href="{{ route('outcomes.show', $outcome->OutcomeId) }}"
                   class="btn btn-xs text-white"
                   style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                    <i class="fas fa-eye"></i>
                </a>

                <!-- Edit -->
                <a href="{{ route('outcomes.edit', $outcome->OutcomeId) }}"
                   class="btn btn-xs text-white"
                   style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                    <i class="fas fa-edit"></i>
                </a>

                <!-- Delete -->
                <form action="{{ route('outcomes.destroy', $outcome->OutcomeId) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this outcome?');">
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
            <td colspan="6" class="text-center text-muted">No outcomes found.</td>
        </tr>
    @endforelse
</tbody>

            </table>
        </div>
    </div>
</div>
@endsection
