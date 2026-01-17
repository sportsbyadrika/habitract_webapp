<?php

class CategoryFeeHeadModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /* =========================
       FETCH ACTIVE CATEGORIES
    ========================== */
    public function getActiveCategories()
    {
        $stmt = $this->db->query("
            SELECT id, name
            FROM member_categories
            WHERE is_active = 1
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /* =========================
       FETCH ACTIVE FEE HEADS
    ========================== */
    public function getActiveFeeHeads()
    {
        $stmt = $this->db->query("
            SELECT id, name, amount, periodicity
            FROM fee_heads
            WHERE status = 1
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getFeeHeadsByCategory($categoryId)
{
    $stmt = $this->db->prepare("
        SELECT 
            fh.id AS fee_head_id,
            fh.name AS fee_head_name,
            fh.amount,
            fh.periodicity,
            cfh.is_mandatory
        FROM category_fee_heads cfh
        JOIN fee_heads fh ON fh.id = cfh.fee_head_id
        WHERE cfh.member_category_id = ?
          AND fh.status = 1
    ");

    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /* =======================================
       FETCH MAPPINGS (CATEGORY → FEE HEADS)
       RETURNS:
       [
         category_id => [fee_head_id, fee_head_id]
       ]
    ======================================== */
    public function getMappedByCategory()
    {
        $stmt = $this->db->query("
            SELECT member_category_id, fee_head_id
            FROM category_fee_heads
        ");

        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
        $mapped = [];

        foreach ($rows as $row) {
            if (!isset($mapped[$row->member_category_id])) {
                $mapped[$row->member_category_id] = [];
            }
            $mapped[$row->member_category_id][] = $row->fee_head_id;
        }

        return $mapped;
    }

    /* =========================
       SAVE / REPLACE MAPPINGS
    ========================== */
    public function replaceMappings($categoryId, array $feeHeads)
    {
        // Delete old mappings
        $stmt = $this->db->prepare("
            DELETE FROM category_fee_heads
            WHERE member_category_id = ?
        ");
        $stmt->execute([$categoryId]);

        // Insert new mappings
        if (!empty($feeHeads)) {
            $stmt = $this->db->prepare("
                INSERT INTO category_fee_heads
                (member_category_id, fee_head_id)
                VALUES (?, ?)
            ");

            foreach ($feeHeads as $feeId) {
                $stmt->execute([$categoryId, $feeId]);
            }
        }
    }
    public function getFeeHeadAmount(int $feeHeadId)
{
    $stmt = $this->db->prepare("
        SELECT id, name, amount
        FROM fee_heads
        WHERE id = ?
          AND status = 1
        LIMIT 1
    ");

    $stmt->execute([$feeHeadId]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}
}
