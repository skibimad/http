<?php
namespace App\Admin\Middleware;

use Juzdy\Http\HandlerInterface;
use Juzdy\Http\Middleware\MiddlewareInterface;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

/**
 * Authentication Middleware
 * 
 * Ensures that the user is authenticated before processing the request.
 * Excludes login and logout routes from authentication check.
 */
class AuthMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(RequestInterface $request, HandlerInterface $handler): ResponseInterface
    {   
        // Check if user is authenticated
        $adminUserId = $request->session('admin_user_id');

        if ($adminUserId === null) {
            // Store the intended URL for redirect after login
            $request->session('intended_url', $request->server('REQUEST_URI') ?? '/admin/');
            
            // Redirect to admin login page (using query string format for compatibility)
            header('Location: /admin/login');
            exit;
        }

        // User is authenticated, continue to next middleware or handler
        return $handler->handle($request);
    }
}
