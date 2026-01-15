<?php
namespace App\Model;

use Juzdy\Model;

class Episode extends Model
{
    const TABLE = 'episodes';

    const COLUMN_ID = 'id';
    const COLUMN_STATUS = 'status';

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    
    protected string $table = self::TABLE;

    public function isEnabled(): bool
    {
        return (bool)$this->get(static::COLUMN_STATUS) == static::STATUS_ENABLED;
    }

    public function getAnchor()
    {
        return $this->get('released_at') ? date('ymdhi', strtotime($this->get('released_at'))) : '';
    }

    public function getVideoUrl(): string
    {
        return $this->get('video_url') ?? '#';
    }



}
