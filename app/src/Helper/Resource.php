<?php
namespace App\Helper;

class Resource extends Helper
{

    protected static string $root = '';
    /**
     * Initialize the Resource helper with the root path
     */
    public static function init( string $rootPath ): void
    {
        static::$root = rtrim($rootPath, '/');
    }

    public static function path(): string
    {
        return static::$root;
    }

    /**
     * Get random background video from fun folder
     */
    public static function getRandomVideo(?string $section = 'fun'): ?string
    {
        $videoPath = static::$root . '/pub/media/video/' . $section . '/';

        if (!is_dir($videoPath)) {
            return null;
        }
        
        $videos = glob($videoPath . '*.{mp4,webm,mov}', GLOB_BRACE);
        
        if (empty($videos)) {
            return null;
        }
        
        $randomVideo = $videos[array_rand($videos)];

        return '/media/video/fun/' . basename($randomVideo);
    }
}