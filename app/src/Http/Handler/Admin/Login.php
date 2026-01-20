<?php

namespace App\Http\Handler\Admin;

use Juzdy\Http\Handler;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Admin\Helper\Auth;

class Login extends Handler
{
    /**
     * Handle login request
     * 
     * @return void
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        // If user is already logged in, redirect to dashboard
        if (Auth::isLoggedIn($request)) {
            return $this->redirect('/admin/index');
            
        }

        if ($request->isPost()) {
            $this->processLogin($request);
            
        }

        // Show login form
        return $this->layout(
            'skibidi/admin/standalone',
            'login',
            [],
        );
    }

    /**
     * Process login attempt
     *
     * @return void
     */
    private function processLogin(RequestInterface $request): ResponseInterface
    {
        $userData = [
            'email' => $request->post('email'),
            'password' => $request->post('password'),
        ];

        try {
            $auth = $this->getAuth();
            $auth->login($userData, $request);
            
            // Login successful - get intended URL or default to admin dashboard
            //$intendedUrl = $this->request()->session('intended_url', '/admin/index');
            //$this->request()->session('intended_url', null);
            
            //$this->redirectReferer();
            return $this->redirect('/admin/index');
        } catch (\Throwable $e) {
            die($e->getMessage());
            $this->response()->addError($e->getMessage());
        }

        // On failure, redirect back to login page
        $this->redirect('/admin/login');
    }

    /**
     * Get Auth helper instance
     *
     * @return Auth
     */
    protected function getAuth(): Auth
    {
        return new Auth();
    }
}
