<?php

class SuperAdminAssociationController extends Controller
{
    private $association;

    public function __construct()
    {
        Auth::requireRole('super_admin');
        $this->association = new Association();
    }

    public function index()
    {
        $status = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';

        $associations = $this->association->all($status, $search);

        $this->view('super_admin/associations/index', compact('associations'));
    }

  public function create()
{
    $districtModel = new District();
    $districts = $districtModel->all();

    $this->view('super_admin/associations/create', [
        'districts' => $districts
    ]);
}

    public function store()
    {
        $this->association->create($_POST);
        header('Location: /habitract_webapp/public/index.php/super-admin/associations');
    }

    public function edit()
    {
        $association = $this->association->find($_GET['id']);
        $districts = (new District())->getAll();

        $this->view('super_admin/associations/edit', compact('association', 'districts'));
    }

    public function update()
    {
        $this->association->update($_POST);
        header('Location: /habitract_webapp/public/index.php/super-admin/associations');
    }

    public function deactivate()
    {
        $this->association->deactivate($_POST['id']);
        header('Location: /habitract_webapp/public/index.php/super-admin/associations');
    }
}
