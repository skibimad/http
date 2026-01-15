<?php
return [
    'middleware' => [
        
        'global' => [
            /**
            * Global middleware that runs for all requests
            */

            \Juzdy\Http\Middleware\CorsMiddleware::class,

            /**
             * Router middleware should be the last in the global stack
             */
            \Juzdy\Http\Router::class
        ],
        
        // Middleware groups for different areas
        'groups' => [
            /**
             * Group middlewares based on handler interfaces they implement.
             *  
             * Handlers implementing AuthenticatableInterface will require authentication
             */
            \App\Http\Handler\AuthenticatableInterface::class => [
                \App\Middleware\AuthMiddleware::class,
            ],
        ],
    ],
];