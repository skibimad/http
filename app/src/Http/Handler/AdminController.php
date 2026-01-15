<?php
namespace App\Controller;

use Juzdy\Contract\ViewInterface;
use Juzdy\Controller;
use App\View\Admin\View;

abstract class AdminController extends Controller
{

    protected function init(): void
    {
    }
    
    protected function registerMiddleware(): void
    {
        // Middleware can be added here if needed for specific admin controllers
        // Example: $this->addMiddlewareByClass(\App\Middleware\AdminLogMiddleware::class);
    }

    protected function getView(string $template, array $params = []): ViewInterface
    {
        
        $view =  new View($this->request(), $template, $params);
        return $view;
    }

}