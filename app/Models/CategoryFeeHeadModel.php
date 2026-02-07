<?php

class CategoryFeeHeadModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /* =========================================
       ACTIVE CATEGORIES (association scoped)
       ========================================= */
    public function getActiveCategories(int $associationAdminId)
    {
        $stmt = $this->db->prepare("
            SELECT id, name
            FROM member_categories
            WHERE association_id = ?
              AND is_active = 1
        ");
        $stmt->execute([$associationAdminId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /* =========================================
       ACTIVE FEE HEADS (association scoped)
       ========================================= */
    public function getActiveFeeHeads(int $associationAdminId)
    {
        $stmt = $this->db->prepare("
            SELECT id, name, amount, periodicity
            FROM fee_heads
            WHERE association_id = ?
              AND status = 1
        ");
        $stmt->execute([$associationAdminId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /* =========================================
       FETCH MAPPINGS (by member category)
       ========================================= */
    public function getMappedByCategory(int $memberCategoryId): array
    {
        $stmt = $this->db->prepare("
            SELECT fee_head_id, is_mandatory
            FROM category_fee_heads
            WHERE member_category_id = ?
        ");
        $stmt->execute([$memberCategoryId]);

        $mapped = [];
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $row) {
            $mapped[$row->fee_head_id] = (int)$row->is_mandatory;
        }

        return $mapped;
    }

    /* =========================================
       REPLACE CATEGORY–FEE MAPPINGS
       ========================================= */
    public function replaceMappings(
        int $memberCategoryId,
        array $feeHeads,
        array $mandatoryFeeHeads = []
    ): void {
        // 1. Delete old mappings
        $stmt = $this->db->prepare("
            DELETE FROM category_fee_heads
            WHERE member_category_id = ?
        ");
        $stmt->execute([$memberCategoryId]);

        // 2. Insert new mappings
        if (!empty($feeHeads)) {
            $stmt = $this->db->prepare("
                INSERT INTO category_fee_heads
                    (member_category_id, fee_head_id, is_mandatory)
                VALUES (?, ?, ?)
            ");

            foreach ($feeHeads as $feeHeadId) {
                $isMandatory = in_array($feeHeadId, $mandatoryFeeHeads) ? 1 : 0;
                $stmt->execute([$memberCategoryId, $feeHeadId, $isMandatory]);
            }
        }
    }
    public function getFeeHeadsForCategory($categoryId)
{
    $stmt = $this->db->prepare("
        SELECT fh.id, fh.name, fh.amount
        FROM category_fee_heads cfh
        JOIN fee_heads fh ON fh.id = cfh.fee_head_id
        WHERE cfh.member_category_id = ?
    ");
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
}