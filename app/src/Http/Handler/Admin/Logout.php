<?php

namespace App\Http\Handler\Admin;

use App\Admin\Helper\Auth;
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
        Auth::logout($request);
        return $this->redirect('/admin/login');
    }
}
