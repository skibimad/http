<?php
namespace App\Helper;

use Juzdy\Http\Request;

class Helper
{
    /**
     * Get the current request instance
     *
     * @return Request
     */
    protected static function getRequest(): Request
    {
        static $request = null;
        if ($request === null) {
            $request = new Request();
        }
        return $request;
    }
}