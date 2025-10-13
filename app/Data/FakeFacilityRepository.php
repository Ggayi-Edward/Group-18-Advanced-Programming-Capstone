<?php

namespace App\Data;

use App\Models\Facility;
use Exception;

class FakeFacilityRepository
{
    private static $file = __DIR__ . '/facilities.json';

    // Optional: used to simulate relationships for testing deletions
    private static $dependencies = [
        'services' => [],
        'equipment' => [],
        'projects' => [],
    ];

    /** Load all facilities from JSON */
    private static function load(): array
    {
        if (!file_exists(self::$file)) {
            return [];
        }

        $data = json_decode(file_get_contents(self::$file), true);
        return $data ?: [];
    }

    /** Save facilities to JSON */
    private static function save(array $facilities): void
    {
        file_put_contents(self::$file, json_encode($facilities, JSON_PRETTY_PRINT));
    }

    /** Reset repository data (used by tests) */
    public static function reset(): void
    {
        if (file_exists(self::$file)) {
            unlink(self::$file);
        }

        // Reset dependencies for a clean state
        self::$dependencies = [
            'services' => [],
            'equipment' => [],
            'projects' => [],
        ];
    }

    /** @return Facility[] */
    public static function all(): array
    {
        $facilities = self::load();
        return array_map(fn($data) => Facility::fromArray($data), $facilities);
    }

    public static function find($id): ?Facility
    {
        $facilities = self::load();
        return isset($facilities[$id]) ? Facility::fromArray($facilities[$id]) : null;
    }

    /**
     * Create a new facility.
     * Enforces: Required fields, uniqueness, and capabilities rules.
     */
    public static function create(array $data): Facility
    {
        $facilities = self::load();

        //  Rule 1: Required Fields
        if (empty($data['Name']) || empty($data['Location']) || empty($data['FacilityType'])) {
            throw new Exception("Facility.Name, Facility.Location, and Facility.FacilityType are required.");
        }

        //  Rule 2: Uniqueness (Name + Location)
        foreach ($facilities as $facility) {
            if (
                strcasecmp($facility['Name'], $data['Name']) === 0 &&
                strcasecmp($facility['Location'], $data['Location']) === 0
            ) {
                throw new Exception("A facility with this name already exists at this location.");
            }
        }

        // Normalize Capabilities
        if (isset($data['Capabilities']) && is_string($data['Capabilities'])) {
            $data['Capabilities'] = array_filter(array_map('trim', explode(',', $data['Capabilities'])));
        } else {
            $data['Capabilities'] = $data['Capabilities'] ?? [];
        }

        // Generate ID
        $id = empty($facilities) ? 1 : max(array_keys($facilities)) + 1;
        $data['FacilityId'] = $id;

        $facilities[$id] = $data;
        self::save($facilities);

        return Facility::fromArray($data);
    }

    /**
     * Update facility details
     */
    public static function update($id, array $data): ?Facility
    {
        $facilities = self::load();
        if (!isset($facilities[$id])) return null;

        // Ensure required fields are not blanked
        $existing = $facilities[$id];
        $merged = array_merge($existing, $data);

        if (empty($merged['Name']) || empty($merged['Location']) || empty($merged['FacilityType'])) {
            throw new Exception("Facility.Name, Facility.Location, and Facility.FacilityType are required.");
        }

        // Update
        $facilities[$id] = $merged;
        self::save($facilities);

        return Facility::fromArray($facilities[$id]);
    }

    /**
     * Delete a facility.
     * Enforces Deletion Constraints.
     */
    public static function delete($id): void
    {
        //  Rule 3: Deletion Constraints
        $hasDeps = self::hasDependencies($id);
        if ($hasDeps) {
            throw new Exception("Facility has dependent records (Services/Equipment/Projects).");
        }

        $facilities = self::load();
        unset($facilities[$id]);
        self::save($facilities);
    }

    /**
     * Rule 4: Capabilities validation
     * Must have at least one capability if services/equipment exist.
     */
    public static function validateCapabilities(array $facility): bool
    {
        $hasServices = !empty($facility['Services']);
        $hasEquipment = !empty($facility['Equipment']);
        $hasCapabilities = !empty($facility['Capabilities']);

        if (($hasServices || $hasEquipment) && !$hasCapabilities) {
            throw new Exception("Facility.Capabilities must be populated when Services/Equipment exist.");
        }

        return true;
    }

    /**
     * Dependency check helper
     */
    private static function hasDependencies($facilityId): bool
    {
        foreach (self::$dependencies as $records) {
            foreach ($records as $rec) {
                if (($rec['FacilityId'] ?? null) == $facilityId) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Allows test setup to inject fake dependent data.
     */
    public static function setFakeDependencies(array $deps): void
    {
        self::$dependencies = array_merge(self::$dependencies, $deps);
    }
}
