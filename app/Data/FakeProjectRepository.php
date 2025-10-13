<?php

namespace App\Data;

use App\Models\Project;
use Exception;

class FakeProjectRepository
{
    private static $file = __DIR__ . '/projects.json';

    /** Load all projects from file */
    private static function load(): array
    {
        if (!file_exists(self::$file)) {
            return [];
        }

        $data = json_decode(file_get_contents(self::$file), true);
        return $data ?: [];
    }

    /** Save projects to file */
    private static function save(array $projects): void
    {
        file_put_contents(self::$file, json_encode($projects, JSON_PRETTY_PRINT));
    }

    /** Reset repository (useful for tests) */
    public static function reset(): void
    {
        self::save([]);
    }

    /** Return all projects as Project models */
    public static function all(): array
    {
        return array_map(fn($data) => Project::fromArray($data), self::load());
    }

    /** Find project by ID */
    public static function find($id): ?Project
    {
        $projects = self::load();
        return isset($projects[$id]) ? Project::fromArray($projects[$id]) : null;
    }

    /** Create a new project with business rules enforced */
    public static function create(array $data): Project
    {
        $projects = self::load();

        // 🧩 Required fields
        if (empty($data['ProgramId']) || empty($data['FacilityId'])) {
            throw new Exception("Project.ProgramId and Project.FacilityId are required.");
        }

        // 🔹 Normalize Participants
        if (!isset($data['Participants'])) {
            $data['Participants'] = [];
        }
        if (is_string($data['Participants'])) {
            $data['Participants'] = array_filter(array_map('trim', explode(',', $data['Participants'])));
        }

        // 🧩 Must have at least one participant
        if (empty($data['Participants'])) {
            throw new Exception("Project must have at least one team member assigned.");
        }

        // 🧩 Completed projects must have outcomes
        if (
            isset($data['Status']) &&
            strtolower($data['Status']) === 'completed' &&
            (empty($data['Outcomes']) || count($data['Outcomes']) < 1)
        ) {
            throw new Exception("Completed projects must have at least one documented outcome.");
        }

        // 🧩 Name uniqueness within same program
        foreach ($projects as $proj) {
            if (
                strcasecmp($proj['Name'], $data['Name']) === 0 &&
                ($proj['ProgramId'] ?? null) == $data['ProgramId']
            ) {
                throw new Exception("A project with this name already exists in this program.");
            }
        }

        // 🧩 Facility compatibility
        if (!empty($data['Requirements']) && !empty($data['FacilityCapabilities'])) {
            $requirements = array_map('strtolower', (array) $data['Requirements']);
            $capabilities = array_map('strtolower', (array) $data['FacilityCapabilities']);

            foreach ($requirements as $req) {
                if (!in_array($req, $capabilities)) {
                    throw new Exception("Project requirements not compatible with facility capabilities.");
                }
            }
        }

        // Normalize all array fields
        foreach (['Participants', 'Outcomes', 'Requirements', 'FacilityCapabilities'] as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = array_filter(array_map('trim', explode(',', $data[$field])));
            }
        }

        // Assign ID and save
        $id = empty($projects) ? 1 : max(array_keys($projects)) + 1;
        $data['ProjectId'] = $id;
        $projects[$id] = $data;

        self::save($projects);

        return Project::fromArray($data);
    }

    /** Update existing project */
    public static function update($id, array $data): ?Project
    {
        $projects = self::load();
        if (!isset($projects[$id])) {
            return null;
        }

        $merged = array_merge($projects[$id], $data);

        // Normalize participants
        if (!isset($merged['Participants'])) {
            $merged['Participants'] = [];
        }
        if (is_string($merged['Participants'])) {
            $merged['Participants'] = array_filter(array_map('trim', explode(',', $merged['Participants'])));
        }

        // Validate required fields
        if (empty($merged['ProgramId']) || empty($merged['FacilityId'])) {
            throw new Exception("Project.ProgramId and Project.FacilityId are required.");
        }

        if (empty($merged['Participants'])) {
            throw new Exception("Project must have at least one team member assigned.");
        }

        if (
            isset($merged['Status']) &&
            strtolower($merged['Status']) === 'completed' &&
            (empty($merged['Outcomes']) || count($merged['Outcomes']) < 1)
        ) {
            throw new Exception("Completed projects must have at least one documented outcome.");
        }

        // Normalize all array fields
        foreach (['Participants', 'Outcomes', 'Requirements', 'FacilityCapabilities'] as $field) {
            if (isset($merged[$field]) && is_string($merged[$field])) {
                $merged[$field] = array_filter(array_map('trim', explode(',', $merged[$field])));
            }
        }

        $projects[$id] = $merged;
        self::save($projects);

        return Project::fromArray($merged);
    }

    /** Delete a project */
    public static function delete($id): void
    {
        $projects = self::load();
        unset($projects[$id]);
        self::save($projects);
    }

    /** Get projects for a specific program */
    public static function forProgram($programId): array
    {
        $rows = self::load();
        $filtered = array_filter($rows, fn($r) => isset($r['ProgramId']) && $r['ProgramId'] == $programId);
        return array_map(fn($r) => Project::fromArray($r), $filtered);
    }

    /** Get projects for a specific facility */
    public static function forFacility($facilityId): array
    {
        $rows = self::load();
        $filtered = array_filter($rows, fn($r) => isset($r['FacilityId']) && $r['FacilityId'] == $facilityId);
        return array_map(fn($r) => Project::fromArray($r), $filtered);
    }
}
