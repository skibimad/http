<?php
namespace App\Model;

use Juzdy\Model;
use Juzdy\Database;

class LandingPageContent extends Model
{
    const TABLE = 'landing_page_content';

    const COLUMN_ID = 'id';
    const COLUMN_SECTION = 'section';
    const COLUMN_FIELD_KEY = 'field_key';
    const COLUMN_FIELD_VALUE = 'field_value';
    const COLUMN_FIELD_TYPE = 'field_type';

    const FIELD_TYPE_STRING = 'string';
    const FIELD_TYPE_RICH = 'rich';
    const FIELD_TYPE_IMAGE = 'image';

    const SECTION_HOME = 'home';
    const SECTION_ABOUT = 'about';
    const SECTION_EPISODES = 'episodes';
    const SECTION_HEROES = 'heroes';
    const SECTION_CHANNEL = 'channel';

    protected string $table = self::TABLE;

    /**
     * Get all sections with their content.
     *
     * @return array Associative array with section as key and fields as value
     */
    public static function getAllSections(): array
    {
        $pdo = Database::connect();
        $stmt = $pdo->query("SELECT * FROM " . self::TABLE . " ORDER BY section, field_key");
        $rows = $stmt->fetchAll();

        $sections = [];
        foreach ($rows as $row) {
            if (!isset($sections[$row['section']])) {
                $sections[$row['section']] = [];
            }
            $sections[$row['section']][$row['field_key']] = [
                'id' => $row['id'],
                'value' => $row['field_value'],
                'type' => $row['field_type'],
            ];
        }

        return $sections;
    }

    /**
     * Get content for a specific section.
     *
     * @param string $section Section name
     * @return array Associative array with field_key as key
     */
    public static function getSection(string $section): array
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE section = :section");
        $stmt->execute(['section' => $section]);
        $rows = $stmt->fetchAll();

        $fields = [];
        foreach ($rows as $row) {
            $fields[$row['field_key']] = [
                'id' => $row['id'],
                'value' => $row['field_value'],
                'type' => $row['field_type'],
            ];
        }

        return $fields;
    }

    /**
     * Get a specific field value.
     *
     * @param string $section Section name
     * @param string $fieldKey Field key
     * @return string|null Field value or null if not found
     */
    public static function getValue(string $section, string $fieldKey): ?string
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare(
            "SELECT field_value FROM " . self::TABLE . " WHERE section = :section AND field_key = :field_key"
        );
        $stmt->execute(['section' => $section, 'field_key' => $fieldKey]);
        $result = $stmt->fetch();

        return $result ? $result['field_value'] : null;
    }

    /**
     * Update or create a field value.
     *
     * @param string $section Section name
     * @param string $fieldKey Field key
     * @param string $value Field value
     * @param string $type Field type (string or rich)
     * @return bool Success status
     */
    public static function setValue(string $section, string $fieldKey, string $value, string $type = self::FIELD_TYPE_STRING): bool
    {
        $pdo = Database::connect();
        
        // Check if record exists
        $stmt = $pdo->prepare(
            "SELECT id FROM " . self::TABLE . " WHERE section = :section AND field_key = :field_key"
        );
        $stmt->execute(['section' => $section, 'field_key' => $fieldKey]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Update
            $stmt = $pdo->prepare(
                "UPDATE " . self::TABLE . " SET field_value = :value, field_type = :type WHERE id = :id"
            );
            return $stmt->execute(['value' => $value, 'type' => $type, 'id' => $existing['id']]);
        } else {
            // Insert
            $stmt = $pdo->prepare(
                "INSERT INTO " . self::TABLE . " (section, field_key, field_value, field_type) VALUES (:section, :field_key, :value, :type)"
            );
            return $stmt->execute(['section' => $section, 'field_key' => $fieldKey, 'value' => $value, 'type' => $type]);
        }
    }

    /**
     * Get available sections configuration.
     *
     * @return array Array of section configurations
     */
    public static function getSectionsConfig(): array
    {
        return [
            self::SECTION_HOME => [
                'title' => 'Home Section',
                'fields' => [
                    'hero_subtitle' => [
                        'label' => 'Hero Subtitle',
                        'type' => self::FIELD_TYPE_STRING,
                    ],
                    'hero_description' => [
                        'label' => 'Hero Description',
                        'type' => self::FIELD_TYPE_RICH,
                    ],
                ],
            ],
            self::SECTION_ABOUT => [
                'title' => 'About Section',
                'fields' => [
                    'title' => [
                        'label' => 'Title',
                        'type' => self::FIELD_TYPE_STRING,
                    ],
                    'about_text' => [
                        'label' => 'About Text',
                        'type' => self::FIELD_TYPE_RICH,
                    ],
                    'image' => [
                        'label' => 'About Image',
                        'type' => self::FIELD_TYPE_IMAGE,
                    ],
                ],
            ],
            self::SECTION_EPISODES => [
                'title' => 'Episodes Section',
                'fields' => [
                    'title' => [
                        'label' => 'Title',
                        'type' => self::FIELD_TYPE_STRING,
                    ],
                    'subtitle' => [
                        'label' => 'Subtitle',
                        'type' => self::FIELD_TYPE_RICH,
                    ],
                ],
            ],
            self::SECTION_HEROES => [
                'title' => 'Heroes Section',
                'fields' => [
                    'title' => [
                        'label' => 'Title',
                        'type' => self::FIELD_TYPE_STRING,
                    ],
                    'subtitle' => [
                        'label' => 'Subtitle',
                        'type' => self::FIELD_TYPE_RICH,
                    ],
                ],
            ],
            self::SECTION_CHANNEL => [
                'title' => 'Channel Section',
                'fields' => [
                    'title' => [
                        'label' => 'Title',
                        'type' => self::FIELD_TYPE_STRING,
                    ],
                    'subtitle' => [
                        'label' => 'Subtitle',
                        'type' => self::FIELD_TYPE_RICH,
                    ],
                ],
            ],
        ];
    }
}
