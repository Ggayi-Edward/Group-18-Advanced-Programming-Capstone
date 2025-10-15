<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeProgramRepository;
use App\Data\FakeProjectRepository;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = FakeProgramRepository::all();
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        // Recognized national alignments
        $recognizedAlignments = ['NDPIII', 'Digital Roadmap', '4IR Strategy', 'SDGs'];

        return view('programs.create', compact('recognizedAlignments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'required|string|max:1000', // now required
            'NationalAlignment' => 'nullable|string',
            'FocusAreas' => 'nullable|string',
            'Phases' => 'nullable|string',
        ], [
            'Name.required' => 'Program name is required.',
            'Description.required' => 'Program description is required.',
        ]);

        // Check for uniqueness of Name
        try {
            FakeProgramRepository::create($data);
        } catch (\Exception $e) {
            return back()->withErrors(['Name' => 'Program name already exists.'])->withInput();
        }

        return redirect()->route('programs.index')
                        ->with('status', 'Program created successfully.');
    }




    public function show($id)
    {
        $program = FakeProgramRepository::find($id);
        abort_unless($program, 404);

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

        try {
            FakeProgramRepository::update($id, $data);
        } catch (\Exception $e) {
            return back()
                ->withErrors(['Name' => "Program name already exists"])
                ->withInput();
        }

        return redirect()->route('programs.index')
                        ->with('status', 'Program updated successfully.');
    }


    public function destroy($id)
    {
        // Check if the program has any projects
        $projects = FakeProjectRepository::forProgram($id);

        if (count($projects) > 0) {
            return redirect()->route('programs.index')
                             ->with('error', 'Program has Projects; archive or reassign before delete.');
        }

        // Safe to delete
        FakeProgramRepository::delete($id);

        return redirect()->route('programs.index')->with('status', 'Program deleted.');
    }
}
