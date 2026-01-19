<?php
return [

    'root' => realpath(__DIR__ . '/../../'), // Root directory of the application

    'bootstrap' => [
        'discover' => true, // Automatically discover and load bootstrap classes from installed packages
    ],
    'http' => [
        'htaccess_handler_rewrite_param' => 'q', // Query parameter for routing (.htaccess override or similar) (internal use)
        'request_handlers_namespace' => [
            '{namespace}\Http\Handler', // Namespace for request handlers
        ],
        //'default_handler' => 'Index', // Default handler if none is specified
    ],
    'alias' => [
        'pub' => 'pub',
        'var' => 'var',
        'logs' => 'log',
        'uploads' => 'uploads',
    ],
    'path' => [
        'pub' => '@{root}/@{alias.pub}',
        'var' => '@{root}/@{alias.var}',
        'logs' => '@{path.var}/@{alias.logs}',
        'uploads' => '@{path.pub}/@{alias.uploads}',
    ],
    
];
