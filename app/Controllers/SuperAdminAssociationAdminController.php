<?php

class SuperAdminAssociationAdminController extends Controller
{
    private $admin;

    public function __construct()
    {
        Auth::requireRole('super_admin');
        $this->admin = new AssociationAdmin();
    }

    public function index()
    {
        $associationId = $_GET['association_id'] ?? null;

        if (!$associationId || !is_numeric($associationId)) {
            http_response_code(400);
            exit('Invalid association');
        }

        $admins = $this->admin->getByAssociation((int)$associationId);

        $this->view(
            'super_admin/association_admin/index',
            compact('admins', 'associationId')
        );
    }

    public function store()
{
    $this->admin->create($_POST);

   // $_SESSION['success'] = 'Admin added successfully';

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

    public function toggle()
    {
        $this->admin->updateStatus(
            (int)$_POST['id'],
            (int)$_POST['status']
        );
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}