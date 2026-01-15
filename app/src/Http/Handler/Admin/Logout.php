<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;
use Juzdy\Helper\Auth;

class Logout extends AdminController
{
    /**
     * Handle logout request
     * 
     * @return void
     */
    public function handle(): void
    {
        Auth::logout();
        
        $this->getRequest()->addInfo('You have been successfully logged out.');
        $this->redirect('/?q=admin/login');
    }
}
