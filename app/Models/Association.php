<?php

class Association
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all associations with optional status & search filters
     */
    public function all($status = null, $search = null): array
    {
        $sql = "
            SELECT 
                a.*, 
                d.name AS district_name
            FROM associations a
            LEFT JOIN districts d ON d.id = a.district_id
            WHERE 1 = 1
        ";

        $params = [];

        if ($status !== null && $status !== '') {
            $sql .= " AND a.status = :status";
            $params[':status'] = $status;
        }

        if (!empty($search)) {
            $sql .= " AND a.name LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }

        $sql .= " ORDER BY a.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create association
     */
    public function create(array $data): void
    {
        $sql = "
            INSERT INTO associations
                (name, association_code, district_id, location, service_start_date, service_end_date, status)
            VALUES
                (:name, :code, :district_id, :location, :start_date, :end_date, 1)
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name'        => $data['name'],
            ':code'        => $data['association_code'],
            ':district_id' => $data['district_id'],
            ':location'    => $data['location'] ?? null,
            ':start_date'  => $data['service_start_date'],
            ':end_date'    => $data['service_end_date'],
        ]);
    }

    /**
     * Find single association
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM associations WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update association
     */
    public function update(array $data): void
    {
        $sql = "
            UPDATE associations SET
                name = :name,
                district_id = :district_id,
                location = :location,
                service_start_date = :start_date,
                service_end_date = :end_date
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name'        => $data['name'],
            ':district_id' => $data['district_id'],
            ':location'    => $data['location'] ?? null,
            ':start_date'  => $data['service_start_date'],
            ':end_date'    => $data['service_end_date'],
            ':id'          => $data['id'],
        ]);
    }

    /**
     * Deactivate association (soft delete)
     */
    public function deactivate(int $id): void
    {
        $stmt = $this->db->prepare(
            "UPDATE associations SET status = 0 WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
    }
}