<?php

namespace App\Helper;

use App\Model\AdminUser;

class Auth extends Helper
{
    /**
     * Check if admin user is logged in
     *
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        $request = static::getRequest();
        return $request->session('admin_user_id') !== null;
    }

    /**
     * Get the currently logged in admin user ID
     *
     * @return int|null
     */
    public static function getAdminUserId(): ?int
    {
        $request = static::getRequest();
        $userId = $request->session('admin_user_id');
        return $userId !== null ? (int)$userId : null;
    }

    /**
     * Attempt to login an admin user
     *
     * @param array $userData Array containing 'email' and 'password'
     * @return void
     * @throws \Exception If credentials are invalid or empty
     */
    public function login(array $userData): void
    {
        $request = static::getRequest();
        
        $email = $userData['email'] ?? '';
        $password = $userData['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            throw new \Exception('Please enter your email and password.');
        }
        
        try {
            $adminUser = new AdminUser();
            $adminUser->loadByEmail($email);
            
            if ($adminUser->getId() && password_verify($password, $adminUser->get('password_hash'))) {
                $request->session('admin_user_id', $adminUser->getId());
                $request->session('admin_user_email', $adminUser->get('email'));
                return;
            }
            
            throw new \Exception('Invalid login credentials.');
        } catch (\Throwable $e) {
            throw new \Exception('Invalid login credentials.');
        }
    }

    /**
     * Logout the current admin user
     *
     * @return void
     */
    public static function logout(): void
    {
        $request = static::getRequest();
        
        // Clear session variables
        $request->session('admin_user_id', null);
        $request->session('admin_user_email', null);
        
        // Clear the request session state
        $request->clearSession();
        
        // Destroy the PHP session completely
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}