<?php

namespace App\Models;

use PDO;

class Member
{
    public function __construct(private PDO $db)
    {
    }

    public function countByAssociation(int $associationId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM members WHERE association_id = :association_id');
        $stmt->bindValue(':association_id', $associationId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return (int) ($result['total'] ?? 0);
    }

    public function findByUser(int $userId): ?array
    {
        $stmt = $this->db->prepare('SELECT m.*, a.name as association_name, a.association_code FROM members m JOIN associations a ON m.association_id = a.id WHERE m.user_id = :user_id LIMIT 1');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $member = $stmt->fetch();
        return $member ?: null;
    }
}
