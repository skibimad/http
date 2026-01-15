<?php
namespace App;

use Juzdy\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function boot(): void
    {
        /**
         * Initialize Resource helper
         * SkibidiMadness hardcode: to remove
         */
        \App\Helper\Resource::init(__DIR__ . '/../..'); //@todo: remove

    }
}