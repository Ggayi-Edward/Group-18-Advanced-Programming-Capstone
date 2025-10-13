<?php

namespace App\Models;

class Program
{
    public $ProgramId;
    public $Name;
    public $Description;
    public $NationalAlignment;
    public $FocusAreas = [];
    public $Phases = [];

    public static function fromArray(array $data): self
    {
        $p = new self();
        $p->ProgramId = $data['ProgramId'] ?? null;
        $p->Name = $data['Name'] ?? '';
        $p->Description = $data['Description'] ?? '';
        $p->NationalAlignment = $data['NationalAlignment'] ?? '';
        $p->FocusAreas = $data['FocusAreas'] ?? [];
        $p->Phases = $data['Phases'] ?? [];
        return $p;
    }

    public function toArray(): array
    {
        return [
            'ProgramId' => $this->ProgramId,
            'Name' => $this->Name,
            'Description' => $this->Description,
            'NationalAlignment' => $this->NationalAlignment,
            'FocusAreas' => $this->FocusAreas,
            'Phases' => $this->Phases,
        ];
    }
}
