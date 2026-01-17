<?php

class FeeHeadModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getActiveFeeHeads()
    {
        $stmt = $this->db->query(
            "SELECT id, name, amount, periodicity
             FROM fee_heads
             WHERE is_active = 1"
        );

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}