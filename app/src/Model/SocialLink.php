<?php
namespace App\Model;

use Juzdy\Model;

class SocialLink extends Model
{
    const TABLE = 'social_links';

    const COLUMN_ID = 'id';
    const COLUMN_PLATFORM = 'platform';
    const COLUMN_URL = 'url';
    const COLUMN_ICON_CLASS = 'icon_class';
    const COLUMN_DISPLAY_ORDER = 'display_order';
    const COLUMN_ENABLED = 'enabled';

    protected string $table = self::TABLE;

    public function isEnabled(): bool
    {
        return (bool)$this->get(self::COLUMN_ENABLED);
    }

    public function getPlatform(): string
    {
        return $this->get(self::COLUMN_PLATFORM) ?? '';
    }

    public function getUrl(): string
    {
        return $this->get(self::COLUMN_URL) ?? '';
    }

    public function getIconClass(): string
    {
        return $this->get(self::COLUMN_ICON_CLASS) ?? '';
    }
}
