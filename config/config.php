<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', BASE_PATH . '/app/Views');
}

if (!defined('BASE_URL')) {
  define('BASE_URL', '/habitract_webapp/public');
}

return [
    'db' => [
        'host' => 'localhost',
        'name' => 'association_saas',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4'
    ]
];