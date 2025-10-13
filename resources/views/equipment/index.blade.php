@extends('layouts.app')

@section('title', 'Manage Equipment')
@section('page-title', 'Manage Equipment')

@section('styles')
<style>
    /* Compact table rows */
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
    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center text-white"
         style="background: linear-gradient(135deg, #2c3e50 0%, #2980b9 100%);">
        <div class="card-title mb-0">
            <i class="fas fa-cogs me-2"></i> All Equipment
        </div>
        <div class="ml-auto">
            <a href="{{ route('equipment.create') }}"
               class="btn btn-sm text-white"
               style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
                <i class="fas fa-plus"></i> Add Equipment
            </a>
        </div>
    </div>

    <!-- Body -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-smaller mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 6%;">ID</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 25%;">Capabilities</th>
                        <th style="width: 25%;">Facility</th>
                        <th class="text-center" style="width: 24%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipment as $item)
                        <tr>
                            <td>{{ $item->EquipmentId }}</td>
                            <td>{{ $item->Name }}</td>

                            {{-- Handle both string and array capabilities safely --}}
                            <td>
                                {{ is_array($item->Capabilities) 
                                    ? implode(', ', $item->Capabilities) 
                                    : ($item->Capabilities ?? 'N/A') }}
                            </td>

                            <td>{{ $item->FacilityName ?? 'N/A' }}</td>

                            <td class="text-center">
                                <a href="{{ route('equipment.show', $item->EquipmentId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('equipment.edit', $item->EquipmentId) }}"
                                   class="btn btn-xs text-white"
                                   style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('equipment.destroy', $item->EquipmentId) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this equipment?');">
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
                            <td colspan="5" class="text-center text-muted py-3">No equipment found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
