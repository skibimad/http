<?php
namespace App\Http\Handler;

use Juzdy\Contract\ViewInterface;
use Juzdy\Http\Handler;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\View\Admin\View;

abstract class AdminController extends Handler implements AuthenticatableInterface
{
    protected ?RequestInterface $requestObj = null;

    /**
     * Handle the HTTP request (framework entry point)
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    final public function handle(RequestInterface $request): ResponseInterface
    {
        // Store request for child methods to access
        $this->requestObj = $request;
        
        // Call child's handleRequest method
        $this->handleRequest();
        
        return $this->response();
    }

    /**
     * Child classes must implement this method
     * This is the entry point for admin handler logic
     *
     * @return void
     */
    abstract protected function handleRequest(): void;

    /**
     * Get the request object
     *
     * @return RequestInterface
     */
    protected function request(): RequestInterface
    {
        return $this->requestObj;
    }

    /**
     * Get a request parameter
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getRequest(string $key, mixed $default = null): mixed
    {
        return $this->requestObj->request($key) ?? $default;
    }

    /**
     * Render admin view template
     *
     * @param string $template
     * @param array $params
     * @param bool $withoutLayout Ignored for now
     * @return void
     */
    protected function renderView(string $template, array $params = [], bool $withoutLayout = false): void
    {
        $view = $this->getView($template, $params);
        $content = $view->render();
        $this->response()->body($content);
    }

    /**
     * Redirect and exit
     *
     * @param string $route
     * @return never
     */
    protected function redirectTo(string $route): never
    {
        parent::redirect($route)->send();
        exit;
    }

    /**
     * Get view instance
     *
     * @param string $template
     * @param array $params
     * @return ViewInterface
     */
    protected function getView(string $template, array $params = []): ViewInterface
    {
        return new View($this->request(), $template, $params);
    }

}