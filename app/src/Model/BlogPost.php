<?php
namespace App\Model;

use Juzdy\Config;
use Juzdy\Model;
use Juzdy\Model\Collection;

class BlogPost extends Model
{
    const TABLE = 'blog_posts';
    
    protected string $table = self::TABLE;

    public function isArchived(): bool
    {
        return (bool)$this->get('archived');
    }

    public function isPublished(): bool
    {
        return (bool)$this->get('published');
    }

    public function publish()
    {
        $isPublished = (int)$this->get('published');
        $publishDate = $isPublished ? null : date('Y-m-d H:i:s');
        $this
            ->set('published', (int)!$isPublished)
            ->set('published_at', $publishDate)
            ->save();
    }

    public function getImageUrl(): string
    {
        return '/'. trim($this->get('image'), '/');
    }

    public function getAnchor()
    {
        return $this->get('published_at') ? date('ymdhi', strtotime($this->get('published_at'))) : '';
    }


    

}
