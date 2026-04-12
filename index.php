<?php
/**
 * Front Controller — akses via localhost/travel-app-output/
 * Tidak perlu mengakses /public/ di URL.
 */

define('BASE_PATH', __DIR__);

// URL subfolder = /travel-app-output (TANPA /public)
define('SUBFOLDER', '/travel-app-output');

// Config
require BASE_PATH . '/config/app.php';
date_default_timezone_set('Asia/Jakarta');

$appConfig = require BASE_PATH . '/config/app.php';
if ($appConfig['debug'] ?? false) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}

// Autoloader PSR-4
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) return;
    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $file = BASE_PATH . '/app/' . $relative . '.php';
    if (file_exists($file)) require $file;
});

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Tandai bootstrap sudah selesai agar public/index.php tidak ulangi
define('APP_CONFIG_LOADED', true);

// Load routing dari public/index.php
require BASE_PATH . '/public/index.php';
