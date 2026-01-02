<?php

class Auth
{
    /**
     * Check if user is logged in (any role)
     */
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Get current role
     */
    public static function role(): ?string
    {
        return $_SESSION['user']['role'] ?? null;
    }

    /**
     * Require a specific role
     */
    public static function requireRole(string $role): void
    {
        if (
            !isset($_SESSION['user']) ||
            ($_SESSION['user']['role'] ?? null) !== $role
        ) {
            http_response_code(403);
            echo 'Unauthorized';
            exit;
        }
    }

    /**
     * Require login (any role)
     */
    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: /habitract_webapp/public/index.php/login');
            exit;
        }
    }
}