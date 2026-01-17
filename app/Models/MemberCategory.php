<?php

class MemberCategory
{
    /* ==============================
       Get ACTIVE categories (Add Member)
       ============================== */
    public function getActiveByAssociation($associationId)
    {
        $sql = "
            SELECT *
            FROM member_categories
            WHERE association_id = ?
              AND is_active = 1
            ORDER BY id DESC
        ";

        $stmt = Database::query($sql, [(int)$associationId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /* ==============================
       Get ALL categories (Settings)
       ============================== */
    public function getAllByAssociation($associationId)
    {
        $sql = "
            SELECT *
            FROM member_categories
            WHERE association_id = ?
            ORDER BY id DESC
        ";

        $stmt = Database::query($sql, [(int)$associationId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /* ==============================
       CREATE category (Settings)
       ============================== */
   public function create($data)
{
   $sql = "
    INSERT INTO member_categories
    (
        association_id,
        name,
        validity_type,
        payment_periodicity,
        amount,
        description,
        is_active
    )
    VALUES (?, ?, ?, ?, ?, ?, 1)
";
    Database::query($sql, [
    (int) $data['association_id'],
    $data['name'],
    $data['validity_type'],        
    $data['payment_periodicity'],  
    $data['amount'],               
    $data['description']
]);
}

    /* ==============================
       Activate / Deactivate category
       ============================== */
    public function toggle($id)
    {
        $sql = "
            UPDATE member_categories
            SET is_active = IF(is_active = 1, 0, 1)
            WHERE id = ?
        ";

        Database::query($sql, [(int)$id]);
    }
}