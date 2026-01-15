<?php
namespace App\Http\Handler;

/**
 * Interface for handlers that require authentication.
 * 
 * Handlers implementing this interface will automatically have
 * authentication middleware applied through the middleware groups
 * configuration.
 */
interface AuthenticatableInterface
{
}
