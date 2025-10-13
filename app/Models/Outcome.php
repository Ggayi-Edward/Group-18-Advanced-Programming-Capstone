<?php

namespace App\Models;

class Outcome
{
    public $OutcomeId;
    public $ProjectId;
    public $Type;                 // e.g., Prototype, CAD, Report
    public $CertificationStatus;  // e.g., Pending, Certified
    public $Commercialization;    // e.g., Idea, Pilot, Market
    public $FilePath;             // path to attached artifact
    public $Description;

    /**
     * Create an Outcome instance from an array.
     */
    public static function fromArray(array $data): self
    {
        $outcome = new self();
        $outcome->OutcomeId           = $data['OutcomeId'] ?? null;
        $outcome->ProjectId           = $data['ProjectId'] ?? null;
        $outcome->Type                = $data['Type'] ?? '';
        $outcome->CertificationStatus = $data['CertificationStatus'] ?? '';
        $outcome->Commercialization   = $data['Commercialization'] ?? '';
        $outcome->FilePath            = $data['FilePath'] ?? '';
        $outcome->Description         = $data['Description'] ?? '';
        return $outcome;
    }

    /**
     * Convert an Outcome instance to an array.
     */
    public function toArray(): array
    {
        return [
            'OutcomeId'           => $this->OutcomeId,
            'ProjectId'           => $this->ProjectId,
            'Type'                => $this->Type,
            'CertificationStatus' => $this->CertificationStatus,
            'Commercialization'   => $this->Commercialization,
            'FilePath'            => $this->FilePath,
            'Description'         => $this->Description,
        ];
    }
}
