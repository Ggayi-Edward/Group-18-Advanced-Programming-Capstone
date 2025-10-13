@extends('layouts.app')

@section('title', 'Manage Participants')
@section('page-title', 'Manage Participants')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Participants</li>
@endsection
@section('styles')
<style>
    .table-smaller th,
    .table-smaller td {
        padding: 0.35rem 0.5rem !important;
        vertical-align: middle !important;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center text-white"
         style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <div class="card-title mb-0">
            <i class="fas fa-users me-2"></i> All Participants
        </div>
        <div class="ml-auto">
            <a href="{{ route('participants.create') }}" 
            class="btn btn-sm text-white"
            style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
                <i class="fas fa-plus"></i> Add Participant
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-smaller mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Affiliation</th>
                        <th>Specialization</th>
                        <th>Cross Skill</th>
                        <th>Institution</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $p)
                        <tr>
                            <td>{{ $p->ParticipantId }}</td>
                            <td>{{ $p->FullName }}</td>
                            <td>{{ $p->Email }}</td>
                            <td>{{ $p->Affiliation }}</td>
                            <td>{{ $p->Specialization }}</td>
                            <td>{{ $p->CrossSkillTrained ? 'Yes' : 'No' }}</td>
                            <td>{{ $p->Institution }}</td>
                            <td class="text-center">
                                <a href="{{ route('participants.show', $p->ParticipantId) }}" 
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('participants.edit', $p->ParticipantId) }}" 
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('participants.destroy', $p->ParticipantId) }}" method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this participant?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs text-white"
                                            style="background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">No participants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
