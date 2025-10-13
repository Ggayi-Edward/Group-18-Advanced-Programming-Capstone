<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeProgramRepository;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = FakeProgramRepository::all();
        return view('programs.index', compact('programs'));
    }

    // In your ProgramController.php's create method
    public function create()
    {
        // Fetch your actual list of recognized alignments from a service or config
        $recognizedAlignments = ['NDPIII', 'Digital Roadmap', '4IR Strategy', 'SDGs'];

        return view('programs.create', compact('recognizedAlignments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'NationalAlignment' => 'nullable|string',
            'FocusAreas' => 'nullable|string',
            'Phases' => 'nullable|string',
        ]);

        FakeProgramRepository::create($data);
        return redirect()->route('programs.index')->with('status', 'Program created.');
    }

    public function show($id)
    {
        $program = FakeProgramRepository::find($id);
        abort_unless($program, 404);

        // get projects for this program (returns array of Project objects or arrays depending on Project repo)
        $projects = FakeProgramRepository::projects($id);

        return view('programs.show', compact('program', 'projects'));
    }

    public function edit($id)
    {
        $program = FakeProgramRepository::find($id);
        abort_unless($program, 404);
        return view('programs.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'NationalAlignment' => 'nullable|string',
            'FocusAreas' => 'nullable|string',
            'Phases' => 'nullable|string',
        ]);

        FakeProgramRepository::update($id, $data);
        return redirect()->route('programs.index')->with('status', 'Program updated.');
    }

    public function destroy($id)
    {
        FakeProgramRepository::delete($id);
        return redirect()->route('programs.index')->with('status', 'Program deleted.');
    }
}
