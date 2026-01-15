<?php
// Router script for PHP built-in server
// Simulates Apache mod_rewrite behavior

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static files directly
if ($uri !== '/' && file_exists(__DIR__ . '/pub' . $uri)) {
    return false; // Serve the file as-is
}

// All other requests go through index.php with query parameter
$_GET['q'] = trim($uri, '/');
$_SERVER['SCRIPT_NAME'] = '/index.php';

require __DIR__ . '/pub/index.php';
