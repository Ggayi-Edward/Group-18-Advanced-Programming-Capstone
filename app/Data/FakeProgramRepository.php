<?php

namespace App\Data;

use App\Models\Program;
use Exception;

class FakeProgramRepository
{
    private static $file = __DIR__ . '/programs.json';

    private static function load(): array
    {
        if (!file_exists(self::$file)) {
            return [];
        }
        $data = json_decode(file_get_contents(self::$file), true);
        return $data ?: [];
    }

    private static function save(array $rows): void
    {
        file_put_contents(self::$file, json_encode($rows, JSON_PRETTY_PRINT));
    }

    /** @return Program[] */
    public static function all(): array
    {
        $rows = self::load();
        return array_map(fn($r) => Program::fromArray($r), $rows);
    }

    public static function find($id): ?Program
    {
        $rows = self::load();
        return isset($rows[$id]) ? Program::fromArray($rows[$id]) : null;
    }

    public static function create(array $data): Program
    {
        $rows = self::load();

        // --- [Rule 1: Required Fields] ---
        if (empty($data['Name'])) {
            throw new Exception("Program.Name is required.");
        }
        if (empty($data['Description'])) {
            throw new Exception("Program.Description is required.");
        }

        // --- [Rule 2: Uniqueness (case-insensitive)] ---
        foreach ($rows as $existing) {
            if (strcasecmp($existing['Name'], $data['Name']) === 0) {
                throw new Exception("Program.Name already exists.");
            }
        }

        // Normalize arrays if passed as comma-separated strings
        if (isset($data['FocusAreas']) && is_string($data['FocusAreas'])) {
            $data['FocusAreas'] = array_filter(array_map('trim', explode(',', $data['FocusAreas'])));
        }
        if (isset($data['Phases']) && is_string($data['Phases'])) {
            $data['Phases'] = array_filter(array_map('trim', explode(',', $data['Phases'])));
        }

        // --- [Rule 3: National Alignment Validation] ---
        $validAlignments = ['NDPIII', 'DigitalRoadmap2023_2028', '4IR'];

        if (!empty($data['FocusAreas'])) {
            $alignment = $data['NationalAlignment'] ?? '';
            $alignmentValid = false;

            foreach ($validAlignments as $token) {
                if (stripos($alignment, $token) !== false) {
                    $alignmentValid = true;
                    break;
                }
            }

            if (!$alignmentValid) {
                throw new Exception("Program.NationalAlignment must include at least one recognized alignment when FocusAreas are specified.");
            }
        }

        // Assign new ID
        $id = empty($rows) ? 1 : max(array_keys($rows)) + 1;
        $data['ProgramId'] = $id;

        $rows[$id] = $data;
        self::save($rows);

        return Program::fromArray($data);
    }

    public static function update($id, array $data): ?Program
    {
        $rows = self::load();
        if (!isset($rows[$id])) return null;

        // Normalize string lists
        if (isset($data['FocusAreas']) && is_string($data['FocusAreas'])) {
            $data['FocusAreas'] = array_filter(array_map('trim', explode(',', $data['FocusAreas'])));
        }
        if (isset($data['Phases']) && is_string($data['Phases'])) {
            $data['Phases'] = array_filter(array_map('trim', explode(',', $data['Phases'])));
        }

        $rows[$id] = array_merge($rows[$id], $data);
        self::save($rows);
        return Program::fromArray($rows[$id]);
    }

    // --- [Rule 4: Lifecycle Protection] ---
    public static function delete($id): void
    {
        $rows = self::load();
        if (!isset($rows[$id])) {
            return;
        }

        // Prevent deletion if program has associated projects
        if (class_exists(\App\Data\FakeProjectRepository::class)) {
            $projects = \App\Data\FakeProjectRepository::forProgram($id);
            if (!empty($projects)) {
                throw new Exception("Program has Projects; archive or reassign before delete.");
            }
        }

        unset($rows[$id]);
        self::save($rows);
    }

    /**
     * Return projects belonging to this program.
     */
    public static function projects($programId): array
    {
        if (class_exists(\App\Data\FakeProjectRepository::class)) {
            return \App\Data\FakeProjectRepository::forProgram($programId);
        }
        return [];
    }
}
