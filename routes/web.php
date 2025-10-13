<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OutcomeController;
use App\Http\Controllers\EquipmentController;

// Dashboard (index page)
Route::get('/', function () {
    return view('dashboard.index');
})->name('home');

// Programs CRUD
Route::resource('programs', ProgramController::class);

// Facilities CRUD
Route::resource('facilities', FacilityController::class);

// Services CRUD
Route::resource('services', ServiceController::class);

// Projects CRUD
Route::resource('projects', ProjectController::class);



// Download artifact
Route::get('/outcomes/{id}/download', [OutcomeController::class, 'download'])
     ->name('outcomes.download');

// Outcomes resource routes
Route::resource('outcomes', OutcomeController::class);



// Participants CRUD
Route::resource('participants', ParticipantController::class);

// Equipment CRUD
Route::resource('equipment', EquipmentController::class);
