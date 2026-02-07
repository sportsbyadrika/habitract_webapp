<?php

class MemberCategoryModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
public function create($data)
{
    $data['is_active'] = $data['is_active'] ?? 1;

    $sql = "
        INSERT INTO member_categories
        (association_id, name, validity_type, payment_periodicity, amount, is_active)
        VALUES (?, ?, ?, ?, ?, ?)
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        $data['association_id'],
        $data['name'],
        $data['validity_type'],
        $data['payment_periodicity'],
        $data['amount'],
        $data['is_active']
    ]);
}
    /**
     * Get all active member categories
     */
   public function getAllByAssociation($associationId)
{
    $sql = "
        SELECT
            id,
            name,
            validity_type,
            payment_periodicity,
            amount,
            is_active
        FROM member_categories
        WHERE association_id = ?
        ORDER BY id DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$associationId]);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

    /**
     * Get base fee amount for category
     */
    public function getBaseAmount($categoryId)
    {
        $sql = "SELECT amount FROM member_categories WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);

        return (float) ($stmt->fetchColumn() ?? 0);
    }
    public function find(int $id)
{
    $sql = "
        SELECT *
        FROM member_categories
        WHERE id = :id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);

    return $stmt->fetch(PDO::FETCH_OBJ);
}
public function setActiveStatus($id, $status)
{
    $sql = "
        UPDATE member_categories
        SET is_active = ?
        WHERE id = ?
    ";

    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$status, $id]);
}
public function getActiveByAssociation($associationId)
{
    $sql = "
        SELECT id, name
        FROM member_categories
        WHERE association_id = ?
        AND is_active = 1
        ORDER BY name ASC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$associationId]);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

}