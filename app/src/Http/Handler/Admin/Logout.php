<?php

namespace App\Http\Handler\Admin;

use Juzdy\Helper\Auth;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Logout extends AdminHandler
{
    /**
     * Handle logout request
     * 
     * @return void
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        Auth::logout();
        
        $this->getRequest()->addInfo('You have been successfully logged out.');
        $this->redirect('/?q=admin/login');
    }
}
