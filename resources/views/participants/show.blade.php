@extends('layouts.app')

@section('title', $participant->FullName)

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

    /* Compact rows for cards */
    .card-body > p {
        margin-bottom: 0.5rem;
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

    <!-- Header with Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">{{ $participant->FullName }}</h3>
        <a href="{{ route('participants.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>

    <!-- Participant Info Card -->
    <div class="card shadow-sm">
        <div class="card-header card-header-gradient">
            <h5 class="mb-0">Participant Information</h5>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $participant->Email ?: '-' }}</p>
            <p><strong>Affiliation:</strong> {{ $participant->Affiliation ?: '-' }}</p>
            <p><strong>Specialization:</strong> {{ $participant->Specialization ?: '-' }}</p>
            <p><strong>Cross Skill Trained:</strong> {{ $participant->CrossSkillTrained ? 'Yes' : 'No' }}</p>
            <p><strong>Institution:</strong> {{ $participant->Institution ?: '-' }}</p>
            <p><strong>Project:</strong> {{ $participant->ProjectName ?: '-' }}</p>
        </div>
    </div>

</div>
@endsection
