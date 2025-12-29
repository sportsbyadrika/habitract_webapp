<?php

class User {

    public static function findByUsername($username) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM users 
            WHERE username = ? AND is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public static function associationAdmins() {
        $db = Database::getInstance();
        return $db->query("
            SELECT id, username
            FROM users
            WHERE user_type = 'association_admin'
        ")->fetchAll();
    }
}