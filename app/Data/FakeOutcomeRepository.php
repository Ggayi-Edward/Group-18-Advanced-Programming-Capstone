<?php

namespace App\Data;

use App\Models\Outcome;

class FakeOutcomeRepository
{
    private static $file = __DIR__ . '/fake_outcomes.json';
    private static $outcomes = [];

    /**
     * Load outcomes from JSON file.
     */
    private static function load(): void
    {
        if (file_exists(self::$file)) {
            self::$outcomes = json_decode(file_get_contents(self::$file), true) ?? [];
        }
    }

    /**
     * Save outcomes to JSON file.
     */
    private static function save(): void
    {
        file_put_contents(self::$file, json_encode(self::$outcomes, JSON_PRETTY_PRINT));
    }

    /**
     * Return all outcomes.
     */
    public static function all(): array
    {
        self::load();
        return array_map([Outcome::class, 'fromArray'], self::$outcomes);
    }

    /**
     * Return outcomes for a specific project.
     */
    public static function forProject($projectId = null): array
    {
        if (!$projectId) {
            return self::all();
        }

        return array_filter(self::all(), fn($o) => $o->ProjectId == $projectId);
    }

    /**
     * Find an outcome by ID.
     */
    public static function find($id): ?Outcome
    {
        self::load();
        foreach (self::$outcomes as $data) {
            if ($data['OutcomeId'] == $id) {
                return Outcome::fromArray($data);
            }
        }
        return null;
    }

    /**
     * Create a new outcome.
     */
    public static function create(array $data): Outcome
    {
        self::load();

        $data['ProjectId'] = $data['ProjectId'] ?? null;
        $data['OutcomeId'] = count(self::$outcomes) + 1;

        self::$outcomes[] = $data;
        self::save();

        return Outcome::fromArray($data);
    }

    /**
     * Update an existing outcome by ID.
     */
    public static function update($id, array $data): ?Outcome
    {
        self::load();
        foreach (self::$outcomes as &$outcome) {
            if ($outcome['OutcomeId'] == $id) {
                $outcome = array_merge($outcome, $data);
                self::save();
                return Outcome::fromArray($outcome);
            }
        }
        return null;
    }

    /**
     * Delete an outcome by ID.
     */
    public static function delete($id): void
    {
        self::load();
        self::$outcomes = array_values(array_filter(
            self::$outcomes,
            fn($outcome) => $outcome['OutcomeId'] != $id
        ));
        self::save();
    }
}
