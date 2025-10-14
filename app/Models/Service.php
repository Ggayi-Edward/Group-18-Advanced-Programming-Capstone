<?php

namespace App\Models;

class Service
{
    public $ServiceId;
    public $FacilityId;
    public $Name;
    public $Description;
    public $Category;
    public $SkillType;
    public $DeliveryMode;
    public $TargetGroups = [];

    public static function fromArray(array $data): self
    {
        $service = new self();
        $service->ServiceId    = $data['ServiceId'] ?? null;
        $service->FacilityId   = $data['FacilityId'] ?? null;
        $service->Name         = $data['Name'] ?? '';
        $service->Description  = $data['Description'] ?? '';
        $service->Category     = $data['Category'] ?? '';
        $service->SkillType    = $data['SkillType'] ?? '';
        $service->DeliveryMode = $data['DeliveryMode'] ?? '';
        $service->TargetGroups = $data['TargetGroups'] ?? [];
        return $service;
    }

    public function toArray(): array
    {
        return [
            'ServiceId'    => $this->ServiceId,
            'FacilityId'   => $this->FacilityId,
            'Name'         => $this->Name,
            'Description'  => $this->Description,
            'Category'     => $this->Category,
            'SkillType'    => $this->SkillType,
            'DeliveryMode' => $this->DeliveryMode,
            'TargetGroups' => $this->TargetGroups,
        ];
    }
}
