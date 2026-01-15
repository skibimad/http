<?php
namespace App\Controller\Api;

use Juzdy\Controller;
use App\Middleware\RateLimitMiddleware;

/**
 * Example API Controller
 * 
 * Demonstrates controller-level middleware registration.
 * This controller applies rate limiting to protect API endpoints.
 */
class DataController extends Controller
{
    /**
     * Register middleware specific to this controller.
     * 
     * This method is called during controller construction and allows
     * each controller to define its own middleware stack.
     */
    protected function registerMiddleware(): void
    {
        // Apply rate limiting to this controller (max 30 requests per minute)
        $this->addMiddleware(new RateLimitMiddleware(30, 60));
        
        // You can also add middleware by class name
        // $this->addMiddlewareByClass(\App\Middleware\LoggingMiddleware::class);
    }

    /**
     * Handle the request
     */
    public function handle(): void
    {
        // Return sample data
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => [
                'message' => 'This endpoint is protected by rate limiting middleware',
                'timestamp' => time(),
            ],
        ]);
    }
}
