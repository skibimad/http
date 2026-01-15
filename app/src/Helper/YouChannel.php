<?php
namespace App\Helper;

class YouChannel
{
    public static function getChannelName(): string
    {
        return 'FireStormX-Tri';
    }

    public static function getChannelUrl(): string
    {
        return 'https://www.youtube.com/@FireStormX-Tri';
    }

    public static function getSubscribeButtonUrl(): string
    {
        return self::getChannelUrl() . '?sub_confirmation=1';
    }
}