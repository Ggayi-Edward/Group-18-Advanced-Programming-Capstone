<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Data\FakeProgramRepository;

class Programs extends Component
{
    public $programs = [];
    public $programId;
    public $name, $description, $nationalAlignment, $focusAreas, $phases;
    public $viewingProgram = null;
    public $editing = false;

    public function mount()
    {
        $this->loadPrograms();
    }

    private function loadPrograms()
    {
        $this->programs = FakeProgramRepository::all();
    }

    public function view($id)
    {
        $this->viewingProgram = FakeProgramRepository::find($id);
        $this->editing = false;
    }

    public function create()
    {
        FakeProgramRepository::create([
            'Name' => $this->name,
            'Description' => $this->description,
            'NationalAlignment' => $this->nationalAlignment,
            'FocusAreas' => array_map('trim', explode(',', $this->focusAreas)),
            'Phases' => array_map('trim', explode(',', $this->phases)),
        ]);

        $this->resetInputs();
        $this->loadPrograms();
    }

    public function edit($id)
    {
        $program = FakeProgramRepository::find($id);
        if ($program) {
            $this->programId = $program->ProgramId;
            $this->name = $program->Name;
            $this->description = $program->Description;
            $this->nationalAlignment = $program->NationalAlignment;
            $this->focusAreas = implode(', ', $program->FocusAreas);
            $this->phases = implode(', ', $program->Phases);
            $this->editing = true;
        }
    }

    public function update()
    {
        FakeProgramRepository::update($this->programId, [
            'Name' => $this->name,
            'Description' => $this->description,
            'NationalAlignment' => $this->nationalAlignment,
            'FocusAreas' => array_map('trim', explode(',', $this->focusAreas)),
            'Phases' => array_map('trim', explode(',', $this->phases)),
        ]);

        $this->resetInputs();
        $this->loadPrograms();
    }

    public function delete($id)
    {
        FakeProgramRepository::delete($id);
        $this->loadPrograms();
    }

    private function resetInputs()
    {
        $this->reset(['programId', 'name', 'description', 'nationalAlignment', 'focusAreas', 'phases', 'editing', 'viewingProgram']);
    }

    public function render()
    {
        return view('livewire.programs');
    }
}
