@extends('layouts.app')

@section('title', $project->Name)
@section('page-title', $project->Name)

@section('styles')
@vite('resources/css/project-details.css')
<link href="{{ asset('css/project-details.css') }}" rel="stylesheet">
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
    /* Compact table rows */
    .table td, .table th {
        padding: .35rem .5rem;
    }
    /* Gradient card headers */
    .card-header-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Project Overview</h3>
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>

    <!-- Top Info Section -->
    <div class="row g-3 mb-4">
        <!-- Project Info -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header card-header-gradient">
                    <h5 class="mb-0">Project Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2"><span class="text-muted small">Description:</span>
                        <div>{{ $project->Description ?: '-' }}</div>
                    </div>
                    <div class="mb-2"><span class="text-muted small">Status:</span>
                        <div>{{ $project->Status ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program & Facility Info -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header card-header-gradient">
                    <h5 class="mb-0">Program & Facility</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2"><span class="text-muted small">Program:</span>
                        <div>{{ $program ? $program->Name : 'N/A' }}</div>
                    </div>
                    <div class="mb-2"><span class="text-muted small">Facility:</span>
                        <div>{{ $facility ? $facility->Name : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants Section -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0">Participants</h4>
        @php $redirectUrl = route('projects.show', $project->ProjectId); @endphp
        <a href="{{ route('participants.create', ['projectId' => $project->ProjectId, 'redirectTo' => $redirectUrl]) }}" 
           class="btn btn-primary btn-sm">Add Participant</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th style="width:110px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($project->Participants ?? [] as $p)
                        @php
                            $pid = $p->ParticipantId;
                            $pname = $p->FullName;
                        @endphp
                        <tr>
                            <td>{{ $pname }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('participants.show', ['participant' => $pid, 'redirectTo' => $redirectUrl]) }}"
                                       class="btn btn-outline-secondary icon-square" title="View">
                                       <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('participants.edit', ['participant' => $pid, 'redirectTo' => $redirectUrl]) }}"
                                       class="btn btn-outline-warning icon-square" title="Edit">
                                       <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('participants.destroy', $pid) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="redirectTo" value="{{ $redirectUrl }}">
                                        <button type="submit"
                                                class="btn btn-outline-danger icon-square"
                                                onclick="return confirm('Remove this participant?')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No participants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Outcomes Section -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0">Outcomes</h4>
        <a href="{{ route('outcomes.create', ['projectId' => $project->ProjectId, 'redirectTo' => $redirectUrl]) }}" 
           class="btn btn-primary btn-sm">Add Outcome</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Outcome</th>
                        <th>Artifact</th>
                        <th style="width:110px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($project->Outcomes ?? [] as $o)
                        @php
                            $oid = $o->OutcomeId ?? null;
                            $title = $o->Type ?? '';
                            $link = $o->FilePath ?? null;
                        @endphp
                        @if($oid)
                        <tr>
                            <td>{{ $title }}</td>
                            <td>
                                @if($link)
                                    <a href="{{ $link }}" target="_blank">View artifact</a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('outcomes.show', ['outcome' => $oid, 'redirectTo' => $redirectUrl]) }}"
                                       class="btn btn-outline-secondary icon-square" title="View">
                                       <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('outcomes.edit', ['outcome' => $oid, 'redirectTo' => $redirectUrl]) }}"
                                       class="btn btn-outline-warning icon-square" title="Edit">
                                       <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('outcomes.destroy', $oid) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="redirectTo" value="{{ $redirectUrl }}">
                                        <button type="submit"
                                                class="btn btn-outline-danger icon-square"
                                                onclick="return confirm('Delete this outcome?')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No outcomes defined.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
