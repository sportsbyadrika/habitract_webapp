<?php

class Auth
{
   
    public static function check(): bool
    {
        return isset($_SESSION['auth']);
    }

    
    public static function role(): ?string
    {
        return $_SESSION['auth']['role'] ?? null;
    }

   
    public static function requireRole(string $role): void
    {
        if (
            !isset($_SESSION['auth']) ||
            ($_SESSION['auth']['role'] ?? null) !== $role
        ) {
            http_response_code(403);
            echo 'Unauthorized';
            exit;
        }
    }

   
    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: /habitract_webapp/public/index.php/login');
            exit;
        }
    }
}