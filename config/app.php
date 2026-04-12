<?php
// Load .env
$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$key, $val] = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val, " \t\n\r\0\x0B\"'");
            $_ENV[$key] = $val;
            if (!array_key_exists($key, $_SERVER)) $_SERVER[$key] = $val;
        }
    }
}

// Define APP_URL constant (used by PaymentService, links, dll)
if (!defined('APP_URL')) {
    define('APP_URL', rtrim($_ENV['APP_URL'] ?? 'http://localhost/travel-app-output', '/'));
}

return [
    'name'     => $_ENV['APP_NAME']  ?? 'TravelKu',
    'url'      => APP_URL,
    'env'      => $_ENV['APP_ENV']   ?? 'development',
    'debug'    => ($_ENV['APP_DEBUG'] ?? 'true') === 'true',
    'key'      => $_ENV['APP_KEY']   ?? 'default-key',
    'timezone' => 'Asia/Jakarta',
];
