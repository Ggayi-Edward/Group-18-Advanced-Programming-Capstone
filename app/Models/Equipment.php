<?php

namespace App\Models;

class Equipment
{
    public $EquipmentId;
    public $FacilityId;
    public $Name;
    public $Capabilities = [];  // can store one or more capabilities
    public $Description;
    public $InventoryCode;
    public $UsageDomain;
    public $SupportPhase = [];  // typically an array like ['Prototyping', 'Testing']

    /**
     * Hydrate an Equipment object from array data.
     */
    public static function fromArray(array $data): self
    {
        $eq = new self();
        $eq->EquipmentId   = $data['EquipmentId']   ?? null;
        $eq->FacilityId    = $data['FacilityId']    ?? null;
        $eq->Name          = $data['Name']          ?? '';
        $eq->Description   = $data['Description']   ?? '';
        $eq->InventoryCode = $data['InventoryCode'] ?? '';
        $eq->UsageDomain   = $data['UsageDomain']   ?? '';
        
        // Normalize Capabilities
        if (isset($data['Capabilities'])) {
            $eq->Capabilities = is_array($data['Capabilities'])
                ? $data['Capabilities']
                : array_filter(array_map('trim', explode(',', (string)$data['Capabilities'])));
        }

        // Normalize SupportPhase
        if (isset($data['SupportPhase'])) {
            $eq->SupportPhase = is_array($data['SupportPhase'])
                ? $data['SupportPhase']
                : array_filter(array_map('trim', explode(',', (string)$data['SupportPhase'])));
        }

        return $eq;
    }

    /**
     * Convert the Equipment object back to a storable array.
     */
    public function toArray(): array
    {
        return [
            'EquipmentId'   => $this->EquipmentId,
            'FacilityId'    => $this->FacilityId,
            'Name'          => $this->Name,
            'Description'   => $this->Description,
            'InventoryCode' => $this->InventoryCode,
            'UsageDomain'   => $this->UsageDomain,
            'Capabilities'  => $this->Capabilities,
            'SupportPhase'  => $this->SupportPhase,
        ];
    }
}
