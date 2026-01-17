<?php

class BillItemModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Insert bill item
     */
    public function add($billId, $itemType, $description, $amount)
    {
        $sql = "
            INSERT INTO bill_items
            (bill_id, item_type, description, amount)
            VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $billId,
            $itemType,
            $description,
            $amount
        ]);
    }

    /**
     * Get items by bill
     */
    public function getByBill($billId)
    {
        $sql = "SELECT * FROM bill_items WHERE bill_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$billId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Calculate bill total
     */
    public function getTotalByBillId($billId)
    {
        $sql = "
            SELECT SUM(amount) AS total
            FROM bill_items
            WHERE bill_id = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$billId]);

        return (float) ($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    }
    public function getItemsByBillId($billId)
{
    $sql = "
        SELECT bi.amount, fh.name AS fee_head
        FROM bill_items bi
        JOIN fee_heads fh ON fh.id = bi.fee_head_id
        WHERE bi.bill_id = ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$billId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
