<?php

// Base paths
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', BASE_PATH . '/app/views');
}

if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    define('BASE_URL', $protocol . $host . '/habitract_webapp/public');
}

/* =========================
   DATABASE CONNECTION
   ========================= */

return [
    'db' => [
        'host' => 'localhost',
        'name' => 'association_saas',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4'
    ]
];