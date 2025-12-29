<?php

class District
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all()
    {
        return $this->db
            ->query("SELECT id, name FROM districts ORDER BY name")
            ->fetchAll();
    }
}