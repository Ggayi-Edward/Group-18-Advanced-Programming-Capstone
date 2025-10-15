<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeProjectRepository;
use App\Data\FakeProgramRepository;
use App\Data\FakeOutcomeRepository;
use App\Data\FakeFacilityRepository;
use App\Data\FakeParticipantRepository;
use Exception;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = FakeProjectRepository::all();

        // Load program and facility for each project
        foreach ($projects as $project) {
            $project->Program = $project->ProgramId
                ? FakeProgramRepository::find($project->ProgramId)
                : null;

            $project->Facility = $project->FacilityId
                ? FakeFacilityRepository::find($project->FacilityId)
                : null;
        }

        return view('projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
        $programs = FakeProgramRepository::all();
        $facilities = FakeFacilityRepository::all();
        $participants = FakeParticipantRepository::all();

        $preselectedProgramId = $request->query('programId');
        $preselectedFacilityId = $request->query('facilityId');

        return view('projects.create', compact(
            'programs',
            'facilities',
            'participants',
            'preselectedProgramId',
            'preselectedFacilityId'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'status' => 'nullable|string',
            'programId' => 'required|integer',
            'facilityId' => 'required|integer',
            'participants' => 'required|string',
        ]);

        $participantsArray = array_map('trim', explode(',', $data['participants']));

        try {
            FakeProjectRepository::create([
                'Name' => $data['name'],
                'Description' => $data['description'] ?? '',
                'StartDate' => $data['startDate'] ?? null,
                'EndDate' => $data['endDate'] ?? null,
                'Status' => $data['status'] ?? 'Planned',
                'ProgramId' => $data['programId'],
                'FacilityId' => $data['facilityId'],
                'Participants' => $participantsArray,
                'Outcomes' => [],
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route('projects.index')
                         ->with('success', 'Project created successfully with team members.');
    }

    public function show($id)
    {
        $project = FakeProjectRepository::find($id);
        if (!$project) abort(404, 'Project not found');

        $program = $project->ProgramId ? FakeProgramRepository::find($project->ProgramId) : null;
        $facility = $project->FacilityId ? FakeFacilityRepository::find($project->FacilityId) : null;

        $project->Participants = $project->Participants ?? [];
        $allOutcomes = FakeOutcomeRepository::all();
        $project->Outcomes = array_values(array_filter($allOutcomes, fn($o) => $o->ProjectId == $id));

        return view('projects.show', compact('project', 'program', 'facility'));
    }

    public function edit($id)
    {
        $project = FakeProjectRepository::find($id);
        if (!$project) abort(404, 'Project not found');

        $programs = FakeProgramRepository::all();
        $facilities = FakeFacilityRepository::all();
        $participants = FakeParticipantRepository::all();

        return view('projects.edit', compact('project', 'programs', 'facilities', 'participants'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'status' => 'nullable|string',
            'programId' => 'required|integer',
            'facilityId' => 'required|integer',
            'participants' => 'required|string',
        ]);

        $participantsArray = array_map('trim', explode(',', $data['participants']));

        FakeProjectRepository::update($id, [
            'Name' => $data['name'],
            'Description' => $data['description'] ?? '',
            'StartDate' => $data['startDate'] ?? null,
            'EndDate' => $data['endDate'] ?? null,
            'Status' => $data['status'] ?? 'Planned',
            'ProgramId' => $data['programId'],
            'FacilityId' => $data['facilityId'],
            'Participants' => $participantsArray,
        ]);

        return redirect()->route('projects.index')
                         ->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = FakeProjectRepository::find($id);
        if (!$project) {
            return redirect()->route('projects.index')
                             ->with('error', 'Project not found.');
        }

        $outcomes = FakeOutcomeRepository::all();
        $projectOutcomes = array_filter($outcomes, fn($o) => $o->ProjectId == $id);

        if (!empty($projectOutcomes)) {
            return redirect()->route('projects.index')
                             ->with('error', 'Cannot delete this project because it has Outcomes under it.');
        }

        FakeProjectRepository::delete($id);

        return redirect()->route('projects.index')
                         ->with('success', 'Project deleted successfully.');
    }
}
