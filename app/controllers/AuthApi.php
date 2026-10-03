<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

require_once APP_DIR . 'controllers/ApiController.php';

/**
 * Token-based authentication endpoints.
 *
 * Issues JWT access + refresh tokens through the LavaLust API library.
 */
class AuthApi extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UserModel');
    }

    /**
     * POST /api/auth/login
     */
    public function login()
    {
        $this->api->require_method('POST');
        $this->api->rate_limit('login', 10, 60);

        $input    = $this->api->body();
        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';

        if ($username === '' || $password === '') {
            $this->api->respond_error('Username and password are required.', 422);
        }

        $user = $this->UserModel->findByUsername($username);

        if (!$user || !$this->passwordMatches($password, $user->password)) {
            $this->api->respond_error('Invalid username or password.', 401);
        }

        $tokens = $this->api->issue_tokens([
            'id'   => $user->id,
            'role' => $user->role ?? 'user',
        ]);

        $this->api->respond([
            'message' => 'Login successful.',
            'user'    => [
                'id'       => $user->id,
                'username' => $user->username,
            ],
            'tokens'  => $tokens,
        ]);
    }

    /**
     * POST /api/auth/refresh
     */
    public function refresh()
    {
        $this->api->require_method('POST');

        $input = $this->api->body();
        $this->api->refresh_access_token($input['refresh_token'] ?? '');
    }

    /**
     * POST /api/auth/logout
     */
    public function logout()
    {
        $this->api->require_method('POST');

        $input = $this->api->body();
        $this->api->revoke_refresh_token($input['refresh_token'] ?? '');

        $this->api->respond(['message' => 'Logged out.']);
    }

    /**
     * GET /api/auth/me
     */
    public function me()
    {
        $auth = $this->api->require_jwt();

        $user = $this->UserModel->findById($auth['sub']);

        if (!$user) {
            $this->api->respond_error('User not found.', 404);
        }

        $this->api->respond([
            'id'       => $user->id,
            'username' => $user->username,
        ]);
    }

    /**
     * Accept both bcrypt hashes and the legacy plaintext password that was
     * stored before the API was introduced.
     */
    private function passwordMatches($plain, $stored)
    {
        if (!is_string($stored) || $stored === '') {
            return false;
        }

        if (strpos($stored, '$2y$') === 0 || strpos($stored, '$2a$') === 0 || strpos($stored, '$2b$') === 0) {
            return password_verify($plain, $stored);
        }

        return hash_equals($stored, $plain);
    }
}
