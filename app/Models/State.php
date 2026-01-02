<?php

class State
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        return $this->db
            ->query("SELECT id, name FROM states ORDER BY name")
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}
