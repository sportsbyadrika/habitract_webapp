<?php

require_once __DIR__ . '/../Models/Association.php';

class AssociationDashboardController extends Controller
{
    public function index()
    {
        // 🔐 Auth check
        if (
            !isset($_SESSION['auth']) ||
            $_SESSION['auth']['role'] !== 'association_admin'
        ) {
            header('Location: /habitract_webapp/public/index.php/login');
            exit;
        }

        $associationName = null;

        if (!empty($_SESSION['auth']['association_id'])) {
            $associationModel = new Association();
            $association = $associationModel->find($_SESSION['auth']['association_id']);
            $associationName = $association['name'] ?? null;
        }

        $this->view('association/dashboard', [
            'associationName' => $associationName
        ]);
    }
}