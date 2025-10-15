<?php

namespace App\Data;

use App\Models\Equipment;
use Exception;

class FakeEquipmentRepository
{
    private static $file = __DIR__ . '/equipment.json';
    private static $activeProjects = []; // 🧩 Added for DeleteGuardTest support

    /** Load all equipment */
    private static function load(): array
    {
        if (!file_exists(self::$file)) return [];
        $json = file_get_contents(self::$file);
        $data = json_decode($json, true);
        return $data ?: [];
    }

    /** Save to file */
    private static function save(array $rows): void
    {
        file_put_contents(self::$file, json_encode($rows, JSON_PRETTY_PRINT));
    }

    /** Convert array data into an Equipment model instance */
    private static function fromArray(array $data): Equipment
    {
        $equipment = new Equipment();
        $equipment->EquipmentId   = $data['EquipmentId']   ?? null;
        $equipment->FacilityId    = $data['FacilityId']    ?? null;
        $equipment->Name          = $data['Name']          ?? '';
        $equipment->Description   = $data['Description']   ?? '';
        $equipment->Capabilities  = $data['Capabilities']  ?? '';
        $equipment->InventoryCode = $data['InventoryCode'] ?? '';
        $equipment->UsageDomain   = $data['UsageDomain']   ?? '';
        $equipment->SupportPhase  = $data['SupportPhase']  ?? [];
        return $equipment;
    }

    /** @return Equipment[] */
    public static function all(): array
    {
        return array_map(fn ($r) => self::fromArray($r), self::load());
    }

    public static function find($id): ?Equipment
    {
        $rows = self::load();
        return isset($rows[$id]) ? self::fromArray($rows[$id]) : null;
    }

    /** Create a new equipment record with business rules enforced */
    public static function create(array $data): Equipment
    {
        $rows = self::load();

        // 🧩 Rule 1: Required Fields
        if (empty($data['FacilityId']) || empty($data['Name']) || empty($data['InventoryCode'])) {
            throw new Exception("Equipment.FacilityId, Equipment.Name, and Equipment.InventoryCode are required.");
        }

        // 🧩 Rule 2: Uniqueness
        foreach ($rows as $row) {
            if (isset($row['InventoryCode']) && strcasecmp($row['InventoryCode'], $data['InventoryCode']) === 0) {
                throw new Exception("Equipment.InventoryCode already exists.");
            }
        }

        // 🧩 Rule 3: UsageDomain–SupportPhase Coherence
        $usageDomain = is_array($data['UsageDomain'] ?? null)
            ? implode(',', $data['UsageDomain'])
            : ($data['UsageDomain'] ?? '');

        if (strcasecmp($usageDomain, 'Electronics') === 0) {
            $phases = array_map('strtolower', (array)($data['SupportPhase'] ?? []));
            if (!in_array('prototyping', $phases) && !in_array('testing', $phases)) {
                throw new Exception("Electronics equipment must support Prototyping or Testing.");
            }
        }

        // Normalize SupportPhase
        if (isset($data['SupportPhase']) && is_string($data['SupportPhase'])) {
            $data['SupportPhase'] = array_filter(array_map('trim', explode(',', $data['SupportPhase'])));
        }

        // Assign new ID
        $id = empty($rows) ? 1 : max(array_keys($rows)) + 1;
        $data['EquipmentId'] = $id;

        // Save
        $rows[$id] = $data;
        self::save($rows);

        return self::fromArray($data);
    }

    /** Update an existing equipment record */
    public static function update($id, array $data): ?Equipment
    {
        $rows = self::load();
        if (!isset($rows[$id])) return null;

        $merged = array_merge($rows[$id], $data);

        if (empty($merged['FacilityId']) || empty($merged['Name']) || empty($merged['InventoryCode'])) {
            throw new Exception("Equipment.FacilityId, Equipment.Name, and Equipment.InventoryCode are required.");
        }

        foreach ($rows as $key => $row) {
            if ($key !== $id && isset($row['InventoryCode']) && strcasecmp($row['InventoryCode'], $merged['InventoryCode']) === 0) {
                throw new Exception("Equipment.InventoryCode already exists.");
            }
        }

        // Coherence check
        $usageDomain = is_array($merged['UsageDomain'] ?? null)
            ? implode(',', $merged['UsageDomain'])
            : ($merged['UsageDomain'] ?? '');

        if (strcasecmp($usageDomain, 'Electronics') === 0) {
            $phases = array_map('strtolower', (array)($merged['SupportPhase'] ?? []));
            if (!in_array('prototyping', $phases) && !in_array('testing', $phases)) {
                throw new Exception("Electronics equipment must support Prototyping or Testing.");
            }
        }

        $rows[$id] = $merged;
        self::save($rows);

        return self::fromArray($merged);
    }

    /** Delete Guard — prevent deletion if used by active project */
    /** Delete Guard — prevent deletion if used by active project */
public static function delete($id): void
{
    $rows = self::load();
    $equipment = $rows[$id] ?? null;
    if (!$equipment) return;

    // 🧩 Check active projects manually (used in tests)
    foreach (self::$activeProjects as $proj) {
        // Normalize project-linked equipment references
        $linkedIds = [];

        if (isset($proj['EquipmentIds'])) {
            $linkedIds = array_map('intval', (array) $proj['EquipmentIds']);
        } elseif (isset($proj['EquipmentId'])) {
            $linkedIds = [(int) $proj['EquipmentId']];
        }

        // Convert $id to int to match
        if (in_array((int)$id, $linkedIds, true)) {
            throw new \Exception("Equipment referenced by active Project.");
        }
    }

    unset($rows[$id]);
    self::save($rows);
}

/** 
 * 🧩 Used by DeleteGuardTest to simulate active projects referencing equipment 
 */
public static function setActiveProjects(array $projects): void
{
    self::$activeProjects = $projects;
}

public static function getActiveProjects(): array
{
    return self::$activeProjects;
}
}