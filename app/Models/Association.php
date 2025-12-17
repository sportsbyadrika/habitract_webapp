<?php

namespace App\Models;

use PDO;

class Association
{
    public function __construct(private PDO $db)
    {
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM associations ORDER BY name');
        return $stmt->fetchAll();
    }

    public function count(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM associations');
        $result = $stmt->fetch();
        return (int) ($result['total'] ?? 0);
    }

    public function countByStatus(bool $active): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM associations WHERE is_active = :is_active');
        $stmt->bindValue(':is_active', $active, PDO::PARAM_BOOL);
        $stmt->execute();
        $result = $stmt->fetch();
        return (int) ($result['total'] ?? 0);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM associations WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $association = $stmt->fetch();
        return $association ?: null;
    }

    public function findByAdminUser(int $userId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM associations WHERE admin_user_id = :user_id LIMIT 1');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $association = $stmt->fetch();
        return $association ?: null;
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO associations (name, local_body_id, location, district_id, association_code, reg_number, registered_with, valid_from, valid_to, service_end_date, admin_user_id, is_active) VALUES (:name, :local_body_id, :location, :district_id, :association_code, :reg_number, :registered_with, :valid_from, :valid_to, :service_end_date, :admin_user_id, :is_active)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':local_body_id' => $data['local_body_id'],
            ':location' => $data['location'],
            ':district_id' => $data['district_id'],
            ':association_code' => $data['association_code'],
            ':reg_number' => $data['reg_number'],
            ':registered_with' => $data['registered_with'],
            ':valid_from' => $data['valid_from'],
            ':valid_to' => $data['valid_to'],
            ':service_end_date' => $data['service_end_date'],
            ':admin_user_id' => $data['admin_user_id'],
            ':is_active' => $data['is_active'],
        ]);
        return (int) $this->db->lastInsertId();
    }
}
