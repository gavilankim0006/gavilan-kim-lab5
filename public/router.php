<?php
/**
 * Serve React frontend from public/dist, API from /api/* routes.
 * This allows one Docker container to serve both.
 */
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// API routes go through LavaLust
if (strpos($uri, '/api/') === 0 || strpos($uri, '/migrate') === 0 || strpos($uri, '/status') === 0 ||
    strpos($uri, '/rollback') === 0 || strpos($uri, '/create-migration') === 0 || strpos($uri, '/refresh') === 0) {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['PHP_SELF'] = '/index.php' . $uri;
    require __DIR__ . '/index.php';
    return;
}

// Static files (assets, favicon, etc.)
if (preg_match('#\.(js|css|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot)$#i', $uri)) {
    $file = __DIR__ . '/dist' . $uri;
    if (file_exists($file) && is_file($file)) {
        return false; // Let Apache serve it
    }
}

// React routes: serve index.html and let React Router handle it
$file = __DIR__ . '/dist/index.html';
if (file_exists($file)) {
    readfile($file);
    return;
}

// Fallback to API if nothing matches
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php' . $uri;
require __DIR__ . '/index.php';
