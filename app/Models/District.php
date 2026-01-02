<?php

class District
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT d.id, d.name, d.state_id
             FROM districts d
             ORDER BY d.name"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByStateId(int $stateId): array
    {
        $stmt = $this->db->prepare(
            "SELECT id, name
             FROM districts
             WHERE state_id = ?
             ORDER BY name"
        );

        $stmt->execute([$stateId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM districts WHERE id = :id LIMIT 1"
        );

        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}