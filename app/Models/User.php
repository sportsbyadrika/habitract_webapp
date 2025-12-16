<?php

namespace App\Models;

use PDO;

class User
{
    public function __construct(private PDO $db)
    {
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO users (username, password_hash, email, user_type, is_active) VALUES (:username, :password_hash, :email, :user_type, :is_active)');
        $stmt->bindValue(':username', $data['username']);
        $stmt->bindValue(':password_hash', $data['password_hash']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':user_type', $data['user_type']);
        $stmt->bindValue(':is_active', $data['is_active'], PDO::PARAM_BOOL);
        $stmt->execute();
        return (int) $this->db->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function getAssociationAdminsCount(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM users WHERE user_type = 'association_admin'");
        $result = $stmt->fetch();
        return (int) ($result['total'] ?? 0);
    }
}
