<?php

namespace App\Models;

class Participant
{
    public $ParticipantId;
    public $FullName;
    public $Email;
    public $Affiliation;
    public $Specialization;
    public $CrossSkillTrained;
    public $Institution;
    public $ProjectId;

    public static function fromArray(array $data): self
    {
        $p = new self();
        $p->ParticipantId     = $data['ParticipantId'] ?? null;
        $p->FullName          = $data['FullName'] ?? '';
        $p->Email             = $data['Email'] ?? '';
        $p->Affiliation       = $data['Affiliation'] ?? '';
        $p->Specialization    = $data['Specialization'] ?? '';
        $p->CrossSkillTrained = $data['CrossSkillTrained'] ?? false;
        $p->Institution       = $data['Institution'] ?? '';
        $p->ProjectId         = $data['ProjectId'] ?? null; // map from form/controller
        return $p;
    }

    public function toArray(): array
    {
        return [
            'ParticipantId'     => $this->ParticipantId,
            'FullName'          => $this->FullName,
            'Email'             => $this->Email,
            'Affiliation'       => $this->Affiliation,
            'Specialization'    => $this->Specialization,
            'CrossSkillTrained' => $this->CrossSkillTrained,
            'Institution'       => $this->Institution,
            'ProjectId'         => $this->ProjectId,
        ];
    }
}
