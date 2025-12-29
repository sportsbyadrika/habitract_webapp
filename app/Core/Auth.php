<?php
class Auth {
    public static function check() {
        return isset($_SESSION['user']);
    }

    public static function user() {
        return $_SESSION['user'] ?? null;
    }

    public static function requireRole(string $role) {
        if (!self::check() || $_SESSION['user']['user_type'] !== $role) {
            http_response_code(403);
            exit('Unauthorized');
        }
    }
}