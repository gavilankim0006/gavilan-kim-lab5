<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * CORS Middleware
 *
 * Handles Cross-Origin Resource Sharing for all API requests.
 * This runs globally to ensure CORS headers are set on every response,
 * including preflight OPTIONS requests.
 */
class CorsMiddleware
{
    /**
     * Handle the request
     *
     * @param Closure $next
     * @return mixed
     */
    public function handle(Closure $next)
    {
        $this->handleCors();

        // Handle preflight OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        return $next();
    }

    /**
     * Handle CORS headers
     *
     * @return void
     */
    private function handleCors(): void
    {
        if (function_exists('_send_cors_headers')) {
            _send_cors_headers();
        }

        header('Content-Type: application/json; charset=UTF-8');
    }
}