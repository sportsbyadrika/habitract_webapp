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
        if (!isset($_GET['association_id'])) {
        die('Association ID missing');
    }

    $associationId = (int) $_GET['association_id'];

    $this->associationModel = new Association();
    $this->associationAdminModel = new AssociationAdmin();

    $association = $this->associationModel->find($associationId);

    if (!$association) {
        die('Association not found');
    }

    
    $admins = $this->associationAdminModel->getByAssociation($associationId);

      $this->view('super_admin/association_admin/index', [
        'association' => $association,
        'admins' => $admins
    ]);
}

    public function store()
{
    if (!isset($_POST['association_id'])) {
        die('Association ID missing');
    }

    $this->associationAdminModel = new AssociationAdmin();
    $this->associationAdminModel->create($_POST);

    $_SESSION['success'] = 'Admin added successfully';
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