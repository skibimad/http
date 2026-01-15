<?php

namespace App\Http\Handler\Admin;

use App\Http\Handler\AdminController;
use Juzdy\Helper\Auth;

class Login extends AdminController
{
    /**
     * Handle login request
     * 
     * @return void
     */
    protected function execute(): void
    {
        // If user is already logged in, redirect to dashboard
        if (Auth::isLoggedIn()) {
            $this->redirect('/admin/index');
            return;
        }

        if ($this->request()->isPost()) {
            $this->processLogin();
            return;
        }

        // Show login form
        $this->render(
            'admin/login',
            [],
            true
        );
    }

    /**
     * Process login attempt
     *
     * @return void
     */
    private function processLogin(): void
    {
        $userData = [
            'email' => $this->request()->post('email'),
            'password' => $this->request()->post('password'),
        ];

        try {
            $auth = $this->getAuth();
            $auth->login($userData);
            
            // Login successful - get intended URL or default to admin dashboard
            //$intendedUrl = $this->request()->session('intended_url', '/admin/index');
            //$this->request()->session('intended_url', null);
            
            //$this->redirectReferer();
            $this->redirect('/admin/index');
            return;
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
