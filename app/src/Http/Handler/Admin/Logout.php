<?php

namespace App\Http\Handler\Admin;

use App\Http\Handler\AdminController;
use App\Helper\Auth;

class Logout extends AdminController
{
    /**
     * Handle logout request
     * 
     * @return void
     */
    protected function handleRequest(): void
    {
        Auth::logout();
        
        $this->getRequest()->addInfo('You have been successfully logged out.');
        $this->redirect('/?q=admin/login');
    }
}
