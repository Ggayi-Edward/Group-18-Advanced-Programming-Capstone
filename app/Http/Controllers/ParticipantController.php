<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeParticipantRepository;
use App\Data\FakeProjectRepository; 

class ParticipantController extends Controller
{
    /**
     * Display a listing of participants.
     */
    public function index()
    {
        $participants = FakeParticipantRepository::all();
        return view('participants.index', compact('participants'));
    }

    /**
     * Show the form for creating a new participant.
     */
    public function create()
    {
        // Load projects for dropdown 
        $projects = FakeProjectRepository::all();
        return view('participants.create', compact('projects'));
    }

    /**
     * Store a newly created participant in the repository.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'fullName'          => 'required|string|max:255',
        'email'             => 'required|email|max:255',
        'affiliation'       => 'required|string|max:255',
        'specialization'    => 'required|string|max:255',
        'crossSkillTrained' => 'required|in:0,1',
        'institution'       => 'required|string|max:255',
        'projectId'         => 'required|integer',
    ]);

    // ✅ Create a Participant object from validated data
    $participant = \App\Models\Participant::fromArray([
        'FullName'          => $validated['fullName'],
        'Email'             => $validated['email'],
        'Affiliation'       => $validated['affiliation'],
        'Specialization'    => $validated['specialization'],
        'CrossSkillTrained' => (int) $validated['crossSkillTrained'],
        'Institution'       => $validated['institution'],
        'ProjectId'         => $validated['projectId'], // note PascalCase
    ]);

    // Save participant into fake repository
    \App\Data\FakeParticipantRepository::create($participant->toArray());

    // Also update the project's Participants list in FakeProjectRepository
    $project = \App\Data\FakeProjectRepository::find($participant->ProjectId);
    if ($project) {
        $project->Participants[] = $participant;
        \App\Data\FakeProjectRepository::update($project->ProjectId, $project->toArray());
    }

    // Redirect back to the project's show page
    return redirect()
        ->route('projects.show', $participant->ProjectId)
        ->with('success', 'Participant created successfully.');
}



    /**
     * Display a single participant.
     */
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

    /**
     * Show the form for editing an existing participant.
     */
public function edit(Request $request, $id)
{
    $participant = FakeParticipantRepository::find($id);
    
    if (!$participant) {
        abort(404, 'Participant not found.');
    }

    // Load projects for dropdown
    $projects = FakeProjectRepository::all();

    // Determine where to redirect after update
    $redirectUrl = $request->query('redirectTo', route('participants.index'));

    return view('participants.edit', compact('participant', 'projects', 'redirectUrl'));
}


    /**
     * Update an existing participant in the repository.
     */
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'fullName'          => 'required|string|max:255',
        'email'             => 'required|email|max:255',
        'affiliation'       => 'required|string|max:255',
        'specialization'    => 'required|string|max:255',
        'crossSkillTrained' => 'required|in:0,1',
        'institution'       => 'required|string|max:255',
        'projectId'         => 'required|integer',
    ]);

    // Update the participant in the repository
    FakeParticipantRepository::update($id, [
        'FullName'          => $validated['fullName'],
        'Email'             => $validated['email'],
        'Affiliation'       => $validated['affiliation'],
        'Specialization'    => $validated['specialization'],
        'CrossSkillTrained' => (int) $validated['crossSkillTrained'],
        'Institution'       => $validated['institution'],
        'ProjectId'         => $validated['projectId'],
    ]);

    // Redirect back to project details page if provided, else fallback to participants.index
    $redirect = $request->input('redirectTo', route('participants.index'));

    return redirect($redirect)
           ->with('success', 'Participant updated successfully.');
}


    /**
     * Remove a participant from the repository.
     */
    public function destroy(Request $request, $id)
{
    \App\Data\FakeParticipantRepository::delete($id);

    // Redirect back to redirectTo if provided, else fallback to participants.index
    $redirect = $request->input('redirectTo') ?? route('participants.index');

    return redirect($redirect)
           ->with('success', 'Participant deleted successfully.');
}

}
