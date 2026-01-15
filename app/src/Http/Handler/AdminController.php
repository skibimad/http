<?php
namespace App\Http\Handler;

use Juzdy\Contract\ViewInterface;
use Juzdy\Http\Handler;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\View\Admin\View;

/**
 * Base class for Admin handlers
 * 
 * All admin handlers should extend this class and will automatically
 * have authentication middleware applied via AdminAuthenticableInterface
 */
abstract class AdminController extends Handler implements AdminAuthenticableInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * {@inheritDoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $this->request = $request;
        
        // Call child implementation
        $this->execute();
        
        // Return the response that was built during execution
        return $this->response();
    }

    /**
     * Execute the admin handler logic
     * Child classes should override this method instead of handle()
     * 
     * @return void
     */
    abstract protected function execute(): void;

    /**
     * Get the current request object
     */
    protected function request(): RequestInterface
    {
        return $this->request;
    }
    
    /**
     * Register middleware for admin controllers
     * Override this method in child controllers to add additional middleware
     */
    protected function registerMiddleware(): void
    {
        // Middleware can be added here if needed for specific admin controllers
        // Example: $this->addMiddlewareByClass(\App\Middleware\AdminLogMiddleware::class);
    }

    /**
     * Get admin-specific view
     */
    protected function getView(string $template, array $params = []): ViewInterface
    {
        $view = new View($this->request(), $template, $params);
        return $view;
    }
}