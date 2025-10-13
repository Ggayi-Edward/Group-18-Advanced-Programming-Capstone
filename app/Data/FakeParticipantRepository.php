<?php

namespace App\Data;

use App\Models\Participant;
use Exception;

class FakeParticipantRepository
{
    private static $file = __DIR__ . '/participants.json';

    /**
     * Remove all stored participants (used in tests)
     */
    public static function reset(): void
    {
        if (file_exists(self::$file)) {
            unlink(self::$file);
        }
    }

    /**
     * Load participants from JSON file
     */
    private static function load(): array
    {
        if (!file_exists(self::$file)) {
            return [];
        }
        $data = json_decode(file_get_contents(self::$file), true);
        return $data ?: [];
    }

    /**
     * Save participants to JSON file
     */
    private static function save(array $participants): void
    {
        file_put_contents(self::$file, json_encode($participants, JSON_PRETTY_PRINT));
    }

    /**
     * Return all participants as model objects
     * @return Participant[]
     */
    public static function all(): array
    {
        return array_map(fn($data) => Participant::fromArray($data), self::load());
    }

    /**
     * Find a participant by ID
     */
    public static function find($id): ?Participant
    {
        $rows = self::load();
        return isset($rows[$id]) ? Participant::fromArray($rows[$id]) : null;
    }

    /**
     * Create new participant
     * Enforces:
     *  - Required fields: FullName, Email, Affiliation
     *  - Email uniqueness (case-insensitive)
     *  - Specialization requirement for CrossSkillTrained
     */
    public static function create(array $data): Participant
    {
        $rows = self::load();

        //  Rule 1: Required Fields
        if (empty($data['FullName']) || empty($data['Email']) || empty($data['Affiliation'])) {
            throw new Exception("Participant.FullName, Participant.Email, and Participant.Affiliation are required.");
        }

        //  Rule 2: Email Uniqueness (case-insensitive)
        foreach ($rows as $row) {
            if (strcasecmp($row['Email'], $data['Email']) === 0) {
                throw new Exception("Participant.Email already exists.");
            }
        }

        //  Rule 3: Cross-skill flag requires Specialization
        if (!empty($data['CrossSkillTrained']) && empty($data['Specialization'])) {
            throw new Exception("Cross-skill flag requires Specialization.");
        }

        // Generate unique ID
        $id = empty($rows) ? 1 : max(array_keys($rows)) + 1;
        $data['ParticipantId'] = $id;

        $rows[$id] = $data;
        self::save($rows);

        return Participant::fromArray($data);
    }

    /**
     * Update an existing participant
     */
    public static function update($id, array $data): ?Participant
    {
        $rows = self::load();
        if (!isset($rows[$id])) {
            return null;
        }

        // Merge updates with existing record
        $updated = array_merge($rows[$id], $data);

        // Re-run rules (especially required + cross-skill)
        if (empty($updated['FullName']) || empty($updated['Email']) || empty($updated['Affiliation'])) {
            throw new Exception("Participant.FullName, Participant.Email, and Participant.Affiliation are required.");
        }

        if (!empty($updated['CrossSkillTrained']) && empty($updated['Specialization'])) {
            throw new Exception("Cross-skill flag requires Specialization.");
        }

        // Email uniqueness check (excluding same record)
        foreach ($rows as $key => $row) {
            if ($key != $id && strcasecmp($row['Email'], $updated['Email']) === 0) {
                throw new Exception("Participant.Email already exists.");
            }
        }

        $rows[$id] = $updated;
        self::save($rows);

        return Participant::fromArray($updated);
    }

    /**
     * Delete a participant
     */
    public static function delete($id): void
    {
        $rows = self::load();
        unset($rows[$id]);
        self::save($rows);
    }
}
