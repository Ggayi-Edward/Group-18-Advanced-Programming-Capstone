@extends('layouts.app')

@section('title', 'Manage Programs')
@section('page-title', 'Manage Programs')

@section('breadcrumb')
    <li class="breadcrumb-item active">Programs</li>
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

    /* Flash messages */
    .alert {
        transition: opacity 0.5s ease-out;
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center text-white"
         style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <div class="card-title mb-0">
            <i class="fas fa-project-diagram mr-2"></i> All Programs
        </div>
        <div class="ml-auto">
            <a href="{{ route('programs.create') }}"
               class="btn btn-sm text-white"
               style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
                <i class="fas fa-plus"></i> Add Program
            </a>
        </div>
    </div>

    <div class="card-body p-0">

        {{-- Flash messages --}}
        <div class="px-3 py-2">
            @if(session('status'))
                <div class="alert alert-success mb-2">{{ session('status') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-2">{{ session('error') }}</div>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped table-smaller mb-0">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th style="width: 8%;">ID</th>
                        <th style="width: 25%;">Name</th>
                        <th style="width: 40%;">National Alignment</th>
                        <th class="text-center" style="width: 27%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $program)
                        <tr>
                            <td>{{ $program->ProgramId }}</td>
                            <td>{{ $program->Name }}</td>
                            <td>{{ $program->NationalAlignment }}</td>
                            <td class="text-center">
                                <a href="{{ route('programs.show', $program->ProgramId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('programs.edit', $program->ProgramId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('programs.destroy', $program->ProgramId) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this program?');">
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
                            <td colspan="4" class="text-center text-muted">No programs found.</td>
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
