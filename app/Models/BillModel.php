<?php

class BillModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Check if a bill already exists for a member/month/year
     */
    public function exists(int $memberId, int $month, int $year): bool
    {
        $sql = "
            SELECT id
            FROM bills
            WHERE member_id = ?
              AND bill_month = ?
              AND bill_year = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$memberId, $month, $year]);

        return (bool) $stmt->fetch();
    }

    /**
     * Create bill (DEFENSIVE: handles missing keys safely)
     */
    public function create(array $data): int
    {
        // 🔐 Defensive defaults (prevents warnings)
        $memberId   = $data['member_id'] ?? null;
        $categoryId = $data['category_id'] ?? null;
        $month      = $data['bill_month'] ?? (int) date('m');
        $year       = $data['bill_year'] ?? (int) date('Y');
        $dueDate    = $data['due_date'] ?? date('Y-m-15');
        $total      = $data['total_amount'] ?? 0;
        $outstanding= $data['outstanding_amount'] ?? 0;

        // 🔴 Absolute safety: prevent duplicate insert
        if ($this->exists($memberId, $month, $year)) {
            return 0; // already exists, controller should skip
        }

        $sql = "
            INSERT INTO bills
            (
                member_id,
                category_id,
                bill_month,
                bill_year,
                due_date,
                total_amount,
                outstanding_amount
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $memberId,
            $categoryId,
            $month,
            $year,
            $dueDate,
            $total,
            $outstanding
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Update bill totals
     */
    public function updateTotals(int $billId, float $total): void
    {
        $sql = "
            UPDATE bills
            SET total_amount = ?,
                outstanding_amount = ?
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$total, $total, $billId]);
    }

    /**
     * Get latest bills (dashboard)
     */
    public function getLatestBills(int $limit = 50): array
    {
        $sql = "
            SELECT
                b.id,
                b.member_id,
                b.bill_month,
                b.bill_year,
                b.total_amount,
                b.status,
                b.outstanding_amount,
                b.due_date,
                m.owner_name,
                m.house_number
            FROM bills b
            JOIN members m ON m.id = b.member_id
            ORDER BY b.bill_year DESC, b.bill_month DESC, b.id DESC
            LIMIT $limit
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get bills by month & year
     */
    public function getBillsByMonthYear(int $month, int $year): array
    {
        $sql = "
            SELECT
                b.id,
                b.member_id,
                b.bill_month,
                b.bill_year,
                b.total_amount,
                b.outstanding_amount,
                b.due_date,
                m.owner_name,
                m.house_number
            FROM bills b
            JOIN members m ON m.id = b.member_id
            WHERE b.bill_month = ?
              AND b.bill_year = ?
            ORDER BY b.id DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$month, $year]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getBillById($billId)
{
    $sql = "
        SELECT b.*,
               m.owner_name AS member_name,
               m.house_number
        FROM bills b
        JOIN members m ON m.id = b.member_id
        WHERE b.id = ?
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$billId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}