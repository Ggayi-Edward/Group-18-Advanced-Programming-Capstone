<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeOutcomeRepository;
use App\Data\FakeProjectRepository;

class OutcomeController extends Controller
{
    // List all outcomes, optionally for a specific project
    public function index($projectId = null)
    {
        $outcomes = $projectId
            ? FakeOutcomeRepository::forProject($projectId)
            : FakeOutcomeRepository::all();

        $outcomes = collect($outcomes);

        return view('outcomes.index', compact('outcomes', 'projectId'));
    }

    // Show a single outcome
public function show(Request $request, $id)
{
    $outcome = FakeOutcomeRepository::find($id);
    abort_unless($outcome, 404);

    $projects = FakeProjectRepository::all();

    // Determine where to redirect when clicking "Back"
    $redirectUrl = $request->query('redirectTo', route('outcomes.index'));

    return view('outcomes.show', compact('outcome', 'projects', 'redirectUrl'));
}


    // Show create form
    public function create()
    {
        $projects = FakeProjectRepository::all();
        return view('outcomes.create', compact('projects'));
    }

    // Store new outcome with file upload support
    public function store(Request $request)
{
    $data = $request->validate([
        'ProjectId'           => 'required|integer',
        'Type'                => 'required|string|max:255',
        'CertificationStatus' => 'nullable|string|max:255',
        'Commercialization'   => 'nullable|string|max:255',
        'FilePath'            => 'nullable|file|mimes:pdf,doc,docx,xlsx,png,jpg,jpeg',
        'Description'         => 'nullable|string',
    ]);

   if ($request->hasFile('FilePath')) {
    $file = $request->file('FilePath');
    $filename = time() . '_' . $file->getClientOriginalName();

    // Store in the standard public folder
    $file->storeAs('public/artifacts', $filename);

    // Save path for Blade view
    $data['FilePath'] = 'storage/artifacts/' . $filename;
}




    // Create the outcome in the fake repository
    $outcome = \App\Models\Outcome::fromArray($data);
    \App\Data\FakeOutcomeRepository::create($outcome->toArray());

    // Update the project’s Outcomes list
    $project = \App\Data\FakeProjectRepository::find($outcome->ProjectId);
    if ($project) {
        $project->Outcomes[] = $outcome;
        \App\Data\FakeProjectRepository::update($project->ProjectId, $project->toArray());
    }

    // 🔑 Check if redirectTo was passed, otherwise fallback
    $redirectUrl = $request->input('redirectTo', route('outcomes.index'));

    return redirect($redirectUrl)
        ->with('success', 'Outcome added successfully.');
}

    // Edit outcome
    public function edit(Request $request, $id)
{
    $outcome = FakeOutcomeRepository::find($id);
    abort_unless($outcome, 404);

    $projects = FakeProjectRepository::all();

    // Determine where to redirect after update
    $redirectUrl = $request->query('redirectTo', route('outcomes.index'));

    return view('outcomes.edit', compact('outcome', 'projects', 'redirectUrl'));
}



    // Update outcome with file upload support
public function update(Request $request, $id)
{
    $data = $request->validate([
        'ProjectId'           => 'required|integer',
        'Type'                => 'required|string|max:255',
        'CertificationStatus' => 'nullable|string|max:255',
        'Commercialization'   => 'nullable|string|max:255',
        'FilePath'            => 'nullable|file|mimes:pdf,doc,docx,xlsx,png,jpg,jpeg',
        'Description'         => 'nullable|string',
    ]);

    // Find the existing outcome
    $outcome = FakeOutcomeRepository::find($id);

    if ($request->hasFile('FilePath')) {
        // Delete old file if exists
        if (!empty($outcome->FilePath)) {
            $oldPath = str_replace('storage/', 'public/', $outcome->FilePath);
            if (file_exists(storage_path($oldPath))) {
                unlink(storage_path($oldPath));
            }
        }

        // Store new file in standard public folder
        $file = $request->file('FilePath');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/artifacts', $filename);
        $data['FilePath'] = 'storage/artifacts/' . $filename; // URL for Blade views
    }

    // Update the fake repository
    FakeOutcomeRepository::update($id, $data);

    // Redirect back
    $redirectUrl = $request->input('redirectTo', route('outcomes.index'));

    return redirect($redirectUrl)
           ->with('status', 'Outcome updated successfully.');
}

 public function download($id)
    {
        $outcome = FakeOutcomeRepository::find($id);
        abort_unless($outcome, 404);

        if (empty($outcome->FilePath)) {
            abort(404, 'File not found.');
        }

        $relativePath = str_replace('storage/', '', $outcome->FilePath);
        $fullPath = storage_path('app/public/' . $relativePath);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found.');
        }

        return response()->download($fullPath);
    }

    // Delete outcome
public function destroy(Request $request, $id)
{
    $outcome = \App\Data\FakeOutcomeRepository::find($id);
    abort_unless($outcome, 404);

    \App\Data\FakeOutcomeRepository::delete($id);

    // Redirect back to redirectTo if provided, else fallback to outcomes.index
    $redirect = $request->input('redirectTo') ?? route('outcomes.index');

    return redirect($redirect)
           ->with('success', 'Outcome deleted successfully.');
}

}
