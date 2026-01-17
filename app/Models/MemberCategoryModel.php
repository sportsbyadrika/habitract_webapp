<?php

class MemberCategoryModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all active member categories
     */
    public function getAll()
    {
        $sql = "SELECT id, name, amount, validity_type, payment_periodicity
                FROM member_categories
                WHERE is_active = 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getActiveCategories()
{
    $stmt = $this->db->query("
        SELECT id, name
        FROM member_categories
        WHERE is_active = 1
    ");
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
}