<?php

class SuperAdminAssociationController extends Controller
{
   private $association;
   private $state;
   private $district;
 public function __construct()
{
    Auth::requireRole('super_admin');

    $this->association = new Association();
    $this->state       = new State();
    $this->district    = new District();
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
    $states = (new State())->getAll();
    $this->view('super_admin/associations/create', compact('states'));
}
    public function store()
    {
        $this->association->create($_POST);
        header('Location: /habitract_webapp/public/index.php/super-admin/associations');
    }

    public function edit()
{
    $id = $_GET['id'] ?? null;
    if (!$id || !is_numeric($id)) {
        header('Location: /habitract_webapp/public/index.php/super-admin/associations');
        exit;
    }

    $association = $this->association->find((int)$id);
    if (!$association) {
        header('Location: /habitract_webapp/public/index.php/super-admin/associations');
        exit;
    }

    $district  = $this->district->find($association['district_id']);
    $stateId = $district['state_id'];
    $states    = $this->state->getAll();
   $districts = $this->district->getByStateId($stateId);

    $this->view('super_admin/associations/edit', [
        'association' => $association,
        'states'      => $states,
        'districts'   => $districts,
        'stateId'     => $stateId,
        'districtId'  => $association['district_id']
    ]);
}

    public function update()
    {
        $this->association->update($_POST);
        header('Location: /habitract_webapp/public/index.php/super-admin/associations');
        exit;
    }

 public function deactivate()
{
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        header('Location: /habitract_webapp/public/index.php/super-admin/associations');
        exit;
    }

    $this->association->deactivate((int)$_POST['id']);

    header('Location: /habitract_webapp/public/index.php/super-admin/associations');
    exit;
}
public function suspend()
{
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        header('Location: /habitract_webapp/public/index.php/super-admin/associations');
        exit;
    }

    $this->association->suspend((int) $_POST['id']);

    header('Location: /habitract_webapp/public/index.php/super-admin/associations');
    exit;
}
public function activate()
{
    $this->association->activate((int)$_POST['id']);
    header('Location: /habitract_webapp/public/index.php/super-admin/associations');
    exit;
}
public function districtsByState()
{
    header('Content-Type: application/json');

    $stateId = $_GET['state_id'] ?? null;

    if (!$stateId || !is_numeric($stateId)) {
        echo json_encode([]);
        exit;
    }

    $districts = $this->district->getByStateId((int)$stateId);
    echo json_encode($districts);
}
}
