<?php
namespace App\Http\Handler;

/**
 * Interface for handlers that require admin authentication
 * 
 * Implementing this interface will automatically apply authentication middleware
 * to the handler via the middleware groups configuration.
 */
interface AdminAuthenticableInterface
{
}
