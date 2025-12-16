<?php
return [
    'app' => [
        'name' => 'SaaS Association Manager'
    ],
    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'database' => getenv('DB_NAME') ?: 'association_manager',
        'user' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4',
    ],
    'security' => [
        'session_name' => 'assoc_session',
        'csrf_token_name' => 'csrf_token',
    ],
];
