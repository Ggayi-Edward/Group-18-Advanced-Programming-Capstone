<?php

namespace App\Data;

use App\Models\Service;
use Exception;

class FakeServiceRepository
{
    private static $file = __DIR__ . '/services.json';

    // Used for Delete Guard testing
    private static $projectRequirements = [];

    /** Load all services */
    private static function load(): array
    {
        if (!file_exists(self::$file)) {
            return [];
        }

        $data = json_decode(file_get_contents(self::$file), true);
        return $data ?: [];
    }

    /** Save all services */
    private static function save(array $services): void
    {
        file_put_contents(self::$file, json_encode($services, JSON_PRETTY_PRINT));
    }

    /** @return Service[] */
    public static function all(): array
    {
        return array_map(fn($data) => Service::fromArray($data), self::load());
    }

    /** Find by ID */
    public static function find($id): ?Service
    {
        $services = self::load();
        return isset($services[$id]) ? Service::fromArray($services[$id]) : null;
    }

    /**
     * Create service
     * Enforces:
     * - Required Fields
     * - Scoped Uniqueness (within a facility)
     */
    public static function create(array $data): Service
    {
        $services = self::load();

        // 🧩 Rule 1: Required Fields
        if (
            empty($data['FacilityId']) ||
            empty($data['Name']) ||
            empty($data['Category']) ||
            empty($data['SkillType'])
        ) {
            throw new Exception("Service.FacilityId, Service.Name, Service.Category, and Service.SkillType are required.");
        }

        // 🧩 Rule 2: Scoped Uniqueness (same facility)
        foreach ($services as $service) {
            if (
                intval($service['FacilityId']) === intval($data['FacilityId']) &&
                strcasecmp($service['Name'], $data['Name']) === 0
            ) {
                throw new Exception("A service with this name already exists in this facility.");
            }
        }

        // Normalize and assign
        $id = empty($services) ? 1 : max(array_keys($services)) + 1;
        $data['ServiceId'] = $id;
        $services[$id] = $data;
        self::save($services);

        return Service::fromArray($data);
    }

    /** Update a service */
    public static function update($id, array $data): ?Service
    {
        $services = self::load();
        if (!isset($services[$id])) return null;

        $merged = array_merge($services[$id], $data);

        // Required Fields still enforced
        if (
            empty($merged['FacilityId']) ||
            empty($merged['Name']) ||
            empty($merged['Category']) ||
            empty($merged['SkillType'])
        ) {
            throw new Exception("Service.FacilityId, Service.Name, Service.Category, and Service.SkillType are required.");
        }

        $services[$id] = $merged;
        self::save($services);

        return Service::fromArray($merged);
    }

    /**
     * Delete Guard — prevents deletion if any project
     * references this service category at same facility.
     */
    public static function delete($id): void
    {
        $services = self::load();
        if (!isset($services[$id])) return;

        $service = $services[$id];
        if (self::isCategoryInUse($service['FacilityId'], $service['Category'])) {
            throw new Exception("Service in use by Project testing requirements.");
        }

        unset($services[$id]);
        self::save($services);
    }

    /** Return all services for a facility */
    public static function forFacility($facilityId): array
    {
        $rows = self::load();
        $filtered = array_filter($rows, fn($r) => intval($r['FacilityId']) === intval($facilityId));
        return array_map(fn($r) => Service::fromArray($r), $filtered);
    }

    /** Filter by category */
    public static function filterByCategory(string $category): array
    {
        $rows = self::load();
        $filtered = array_filter($rows, fn($r) =>
            isset($r['Category']) && stripos($r['Category'], $category) !== false
        );
        return array_map(fn($r) => Service::fromArray($r), $filtered);
    }

    /**
     * Delete guard helper
     */
    private static function isCategoryInUse($facilityId, $category): bool
    {
        foreach (self::$projectRequirements as $project) {
            if (
                intval($project['FacilityId']) === intval($facilityId) &&
                in_array($category, $project['TestingRequirements'] ?? [], true)
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Used by tests to simulate project testing dependencies
     */
    public static function setFakeProjectRequirements(array $requirements): void
    {
        self::$projectRequirements = $requirements;
    }
}
