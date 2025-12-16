<?php

namespace App\Core;

class Security
{
    public static function startSession(string $name): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name($name);
            session_set_cookie_params([
                'httponly' => true,
                'secure' => isset($_SERVER['HTTPS']),
                'samesite' => 'Strict',
                'path' => '/',
            ]);
            session_start();
        }
    }

    public static function generateCsrfToken(string $tokenName): string
    {
        if (empty($_SESSION[$tokenName])) {
            $_SESSION[$tokenName] = bin2hex(random_bytes(32));
        }
        return $_SESSION[$tokenName];
    }

    public static function validateCsrfToken(string $tokenName, ?string $token): bool
    {
        return isset($_SESSION[$tokenName]) && hash_equals($_SESSION[$tokenName], (string) $token);
    }

    public static function sanitize(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
