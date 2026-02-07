<?php

class BillModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /* ===============================
       CHECK IF BILLS ALREADY EXIST
       =============================== */
    public function billsExist($associationId, $categoryId, $month, $year)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM bills b
            JOIN members m ON m.id = b.member_id
            WHERE m.association_id = ?
              AND b.category_id = ?
              AND b.bill_month = ?
              AND b.bill_year = ?
        ");
        $stmt->execute([$associationId, $categoryId, $month, $year]);
        return $stmt->fetchColumn() > 0;
    }
public function getBillsByAssociation($associationId)
{
    $stmt = $this->db->prepare("
        SELECT
            b.id,
            b.bill_month,
            b.bill_year,
            b.total_amount,
            b.outstanding_amount,
            b.status,
            b.created_at,

            -- ✅ ADD THESE TWO
            b.whatsapp_sent,
            b.whatsapp_sent_at,

            m.owner_name AS member_name,
            c.name AS category_name
        FROM bills b
        JOIN members m ON m.id = b.member_id
        JOIN member_categories c ON c.id = b.category_id
        WHERE m.association_id = ?
        ORDER BY b.created_at DESC
    ");

    $stmt->execute([$associationId]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
    /* ===============================
       CREATE BILL
       =============================== */
   public function createBill($memberId, $categoryId, $month, $year)
{
    $stmt = $this->db->prepare("
        INSERT INTO bills
        (
            member_id,
            category_id,
            bill_month,
            bill_year,
            total_amount,
            outstanding_amount,
            status
        )
        VALUES (?, ?, ?, ?, 0, 0, 'generated')
    ");

    $stmt->execute([
        $memberId,
        $categoryId,
        $month,
        $year
    ]);

    return $this->db->lastInsertId();
}

    /* ===============================
       ADD BILL ITEM
       =============================== */
  public function addBillItem($billId, $type, $description, $amount)
{
    $stmt = $this->db->prepare("
        INSERT INTO bill_items (bill_id, item_type, description, amount)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$billId, $type, $description, $amount]);
}
public function hasMembershipFeeForYear($memberId, $year)
{
    $sql = "
        SELECT COUNT(*)
        FROM bill_items bi
        INNER JOIN bills b ON b.id = bi.bill_id
        WHERE b.member_id = ?
          AND bi.item_type = 'membership_fee'
          AND YEAR(b.created_at) = ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$memberId, $year]);

    return $stmt->fetchColumn() > 0;
}


    /* ===============================
       UPDATE BILL TOTALS
       =============================== */
    public function updateTotal($billId, $total)
    {
        $stmt = $this->db->prepare("
            UPDATE bills
            SET total_amount = ?, outstanding_amount = ?
            WHERE id = ?
        ");
        $stmt->execute([$total, $total, $billId]);
    }
    public function getBillsSummary($associationId)
{
    $stmt = $this->db->prepare("
        SELECT
            SUM(total_amount) AS total_billed,
            SUM(outstanding_amount) AS total_outstanding,
            SUM(total_amount - outstanding_amount) AS total_paid
        FROM bills b
        JOIN members m ON m.id = b.member_id
        WHERE m.association_id = ?
    ");
    $stmt->execute([$associationId]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}
public function getBillById($billId, $associationId)
{
    $sql = "
        SELECT
            b.id,
            b.member_id,
            b.category_id,
            b.bill_month,
            b.bill_year,
            b.total_amount,
            b.outstanding_amount,
            b.whatsapp_sent,
            b.whatsapp_sent_at,
            b.payment_url,
            m.owner_name AS member_name,
            m.mobile_number,
            c.name AS category_name
        FROM bills b
        JOIN members m ON m.id = b.member_id
        JOIN member_categories c ON c.id = b.category_id
        WHERE b.id = :bill_id
          AND m.association_id = :association_id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'bill_id' => $billId,
        'association_id' => $associationId
    ]);

    return $stmt->fetch(PDO::FETCH_OBJ);
}


public function getBillItems($billId)
{
    $stmt = $this->db->prepare("
        SELECT item_type, description, amount
        FROM bill_items
        WHERE bill_id = ?
    ");
    $stmt->execute([$billId]);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
public function markWhatsappSent($billId)
{
    $stmt = $this->db->prepare("
        UPDATE bills 
        SET whatsapp_sent = 1, whatsapp_sent_at = NOW()
        WHERE id = ?
    ");
    return $stmt->execute([$billId]);
}


}
