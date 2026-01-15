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
        
        // Note: addInfo is not available in the framework, so we'll skip this for now
        // The redirect to login page is sufficient
        $this->redirectTo('/?q=admin/login');
    }
}
