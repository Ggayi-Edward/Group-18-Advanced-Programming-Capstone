<?php

namespace App\Models;

class Facility
{
    public $FacilityId;
    public $Name;
    public $Location;
    public $Description;
    public $PartnerOrganization;
    public $FacilityType;
    public $Capabilities = [];

    public static function fromArray(array $data): self
    {
        $facility = new self();
        $facility->FacilityId = $data['FacilityId'] ?? null;
        $facility->Name = $data['Name'] ?? '';
        $facility->Location = $data['Location'] ?? '';
        $facility->Description = $data['Description'] ?? '';
        $facility->PartnerOrganization = $data['PartnerOrganization'] ?? '';
        $facility->FacilityType = $data['FacilityType'] ?? '';
        $facility->Capabilities = $data['Capabilities'] ?? [];
        return $facility;
    }

    public function toArray(): array
    {
        return [
            'FacilityId' => $this->FacilityId,
            'Name' => $this->Name,
            'Location' => $this->Location,
            'Description' => $this->Description,
            'PartnerOrganization' => $this->PartnerOrganization,
            'FacilityType' => $this->FacilityType,
            'Capabilities' => $this->Capabilities,
        ];
    }
}
