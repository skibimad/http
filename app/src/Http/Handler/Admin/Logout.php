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
    protected function execute(): void
    {
        Auth::logout();
        
        $this->redirect('/admin/login');
    }
}
