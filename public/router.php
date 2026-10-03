<?php
/**
 * Router for PHP's built-in development server (`php lava serve`).
 * Apache uses public/.htaccess instead.
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');

if ($uri !== '/' && $uri !== '' && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF']    = '/index.php' . ($uri === '/' ? '' : $uri);

require __DIR__ . '/index.php';
