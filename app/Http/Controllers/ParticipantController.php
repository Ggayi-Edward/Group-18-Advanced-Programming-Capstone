<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeParticipantRepository;
use App\Data\FakeProjectRepository; 

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = FakeParticipantRepository::all();
        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        $projects = FakeProjectRepository::all();
        return view('participants.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullName'          => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'affiliation'       => 'required|string|max:255',
            'specialization'    => 'nullable|string|max:255',
            'crossSkillTrained' => [
                'required',
                'in:0,1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && empty($request->input('specialization'))) {
                        $fail('Crosskilled/Trained cannot be true without a specialization.');
                    }
                },
            ],
            'institution'       => 'required|string|max:255',
            'projectId'         => 'required|integer',
        ]);

        // Check if email already exists
        $existing = FakeParticipantRepository::all();
        foreach ($existing as $p) {
            if (strcasecmp($p->Email, $validated['email']) === 0) {
                return back()
                    ->withInput()
                    ->withErrors(['email' => 'This email is already registered. Please use a different one.']);
            }
        }

        $participant = \App\Models\Participant::fromArray([
            'FullName'          => $validated['fullName'],
            'Email'             => $validated['email'],
            'Affiliation'       => $validated['affiliation'],
            'Specialization'    => $validated['specialization'],
            'CrossSkillTrained' => (int) $validated['crossSkillTrained'],
            'Institution'       => $validated['institution'],
            'ProjectId'         => $validated['projectId'],
        ]);

        FakeParticipantRepository::create($participant->toArray());

        $project = FakeProjectRepository::find($participant->ProjectId);
        if ($project) {
            $project->Participants[] = $participant;
            FakeProjectRepository::update($project->ProjectId, $project->toArray());
        }

        return redirect()
            ->route('participants.index', $participant->ProjectId)
            ->with('success', 'Participant created successfully.');
    }

    public function show($id)
    {
        $participant = FakeParticipantRepository::find($id);
        if (!$participant) {
            abort(404, 'Participant not found.');
        }

        $project = FakeProjectRepository::find($participant->ProjectId);
        $participant->ProjectName = $project ? $project->Name : 'N/A';

        return view('participants.show', compact('participant'));
    }

    public function edit(Request $request, $id)
    {
        $participant = FakeParticipantRepository::find($id);
        if (!$participant) abort(404, 'Participant not found.');

        $projects = FakeProjectRepository::all();
        $redirectUrl = $request->query('redirectTo', route('participants.index'));

        return view('participants.edit', compact('participant', 'projects', 'redirectUrl'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fullName'          => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'affiliation'       => 'required|string|max:255',
            'specialization'    => 'nullable|string|max:255',
            'crossSkillTrained' => [
                'required',
                'in:0,1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && empty($request->input('specialization'))) {
                        $fail('Crosskilled/Trained cannot be true without a specialization.');
                    }
                },
            ],
            'institution'       => 'nullable|string|max:255',
            'projectId'         => 'required|integer',
        ]);

        FakeParticipantRepository::update($id, [
            'FullName'          => $validated['fullName'],
            'Email'             => $validated['email'],
            'Affiliation'       => $validated['affiliation'],
            'Specialization'    => $validated['specialization'],
            'CrossSkillTrained' => (int) $validated['crossSkillTrained'],
            'Institution'       => $validated['institution'],
            'ProjectId'         => $validated['projectId'],
        ]);

        $redirect = $request->input('redirectTo', route('participants.index'));

        return redirect($redirect)
               ->with('success', 'Participant updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        FakeParticipantRepository::delete($id);
        $redirect = $request->input('redirectTo') ?? route('participants.index');

        return redirect($redirect)
               ->with('success', 'Participant deleted successfully.');
    }
}
