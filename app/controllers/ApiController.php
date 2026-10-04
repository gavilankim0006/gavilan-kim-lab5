<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

require_once SYSTEM_DIR . 'libraries/Api.php';

/**
 * Base controller for the JSON API.
 *
 * Loading the `api` library runs its CORS handling (including the OPTIONS
 * preflight short-circuit) and makes the JSON response helpers available.
 */
class ApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
    }

    /**
     * Simple health check so the API root is not a 404.
     */
    public function index()
    {
        $this->api->respond([
            'status'  => 'ok',
            'name'    => 'Product Management API',
            'message' => 'LavaLust API is running.',
        ]);
    }
}
