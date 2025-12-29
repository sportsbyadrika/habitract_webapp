<?php

class SuperAdminController extends Controller {
    
    public function dashboard() {
    Auth::requireRole('super_admin');

    $db = Database::getInstance();

    $total = $db->query("SELECT COUNT(*) FROM associations")->fetchColumn();

    $active = $db->query("
        SELECT COUNT(*) FROM associations
        WHERE service_end_date IS NULL 
           OR service_end_date >= CURDATE()
    ")->fetchColumn();

    $inactive = $total - $active;

    $this->view('super_admin/dashboard', compact('total', 'active', 'inactive'));
}

    
    }