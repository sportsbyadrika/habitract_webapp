<?php

class AssociationAdmin
{
    private $db;

    public function __construct()
    {
        // Database::getInstance() already returns PDO
        $this->db = Database::getInstance();
    }

    public function getByAssociation(int $associationId): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM association_admins WHERE association_id = ?"
        );
        $stmt->execute([$associationId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO association_admins
            (association_id, name, mobile, email, designation, password, is_active, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 1, NOW())"
        );

        $stmt->execute([
            $data['association_id'],
            $data['name'],
            $data['mobile'],
            $data['email'],
            $data['designation'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    public function updateStatus(int $id, int $status): void
    {
        $stmt = $this->db->prepare(
            "UPDATE association_admins SET is_active = ? WHERE id = ?"
        );
        $stmt->execute([$status, $id]);
    }
}