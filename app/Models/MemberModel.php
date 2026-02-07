<?php

class MemberModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /* =====================================
     * Get all members for an association
     * Used in MembersController@index
     * ===================================== */
    public function getAllByAssociation(int $associationId): array
    {
        $sql = "
            SELECT 
                m.*,
                c.name AS category_name
            FROM members m
            LEFT JOIN member_categories c
                ON m.member_category_id = c.id
            WHERE m.association_id = :aid
            ORDER BY m.id DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['aid' => $associationId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCategoriesByAssociation($associationId)
{
    $stmt = $this->db->prepare("
        SELECT id, name
        FROM member_categories
        WHERE association_id = ?
          AND is_active = 1
    ");
    $stmt->execute([$associationId]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
 public function getMembersByCategory($associationId, $categoryId)
{
    $stmt = $this->db->prepare("
        SELECT 
            id,
            owner_name AS name
        FROM members
        WHERE association_id = ?
          AND member_category_id = ?
    ");
    $stmt->execute([$associationId, $categoryId]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO members (
                association_id,
                house_number,
                owner_name,
                mobile_number,
                occupants,
                location,
                remarks,
                member_category_id,
                membership_start_date
            ) VALUES (
                :association_id,
                :house_number,
                :owner_name,
                :mobile_number,
                :occupants,
                :location,
                :remarks,
                :member_category_id,
                :membership_start_date
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'association_id'       => $data['association_id'],
            'house_number'         => $data['house_number'],
            'owner_name'           => $data['owner_name'],
            'mobile_number'        => $data['mobile_number'],
            'occupants'            => $data['occupants'] ?? null,
            'location'             => $data['location'] ?? null,
            'remarks'              => $data['remarks'] ?? null,
            'member_category_id'   => $data['member_category_id'],
            'membership_start_date'=> $data['membership_start_date'] ?? date('Y-m-d'),
        ]);
    }

    /* =====================================
     * Find member by ID + association
     * Used in edit()
     * ===================================== */
    public function findByIdAndAssociation(int $id, int $associationId)
    {
        $sql = "
            SELECT *
            FROM members
            WHERE id = :id
              AND association_id = :association_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'association_id' => $associationId
        ]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
public function getMemberById(int $id)
{
    $sql = "
        SELECT *
        FROM members
        WHERE id = :id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    /* =====================================
     * Update member (future)
     * ===================================== */
    public function update(int $id, int $associationId, array $data): bool
    {
        $sql = "
            UPDATE members
            SET
                house_number       = :house_number,
                owner_name         = :owner_name,
                mobile_number      = :mobile_number,
                occupants          = :occupants,
                location           = :location,
                remarks            = :remarks,
                member_category_id = :member_category_id
            WHERE id = :id
              AND association_id = :association_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'house_number'       => $data['house_number'],
            'owner_name'         => $data['owner_name'],
            'mobile_number'      => $data['mobile_number'],
            'occupants'          => $data['occupants'] ?? null,
            'location'           => $data['location'] ?? null,
            'remarks'            => $data['remarks'] ?? null,
            'member_category_id' => $data['member_category_id'],
            'id'                 => $id,
            'association_id'     => $associationId
        ]);
    }

    /* =====================================
     * Count active members (dashboard)
     * ===================================== */
    public function countByAssociation(int $associationId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS total
            FROM members
            WHERE association_id = :aid
        ");

        $stmt->execute(['aid' => $associationId]);

        return (int) $stmt->fetch(PDO::FETCH_OBJ)->total;
    }
    public function isMembershipDue(object $member, int $billMonth, int $billYear): bool
{
    if (empty($member->membership_start_date)) {
        // Safety fallback – treat as first-time
        return true;
    }

    $startDate = new DateTime($member->membership_start_date);
    $billDate  = new DateTime($billYear . '-' . str_pad($billMonth, 2, '0', STR_PAD_LEFT) . '-01');

    // Next renewal date = start date + 1 year
    $nextRenewal = (clone $startDate)->modify('+1 year');

    return $billDate >= $nextRenewal;
}

public function renewMembership(int $memberId, int $billMonth, int $billYear): void
{
    $renewalDate = $billYear . '-' . str_pad($billMonth, 2, '0', STR_PAD_LEFT) . '-01';

    $sql = "
        UPDATE members
        SET membership_start_date = :renewal_date
        WHERE id = :member_id
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'renewal_date' => $renewalDate,
        'member_id'    => $memberId
    ]);
}
public function find(int $id)
{
    $stmt = $this->db->prepare(
        "SELECT * FROM members WHERE id = :id LIMIT 1"
    );
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}
}