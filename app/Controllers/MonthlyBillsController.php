<?php

class MonthlyBillsController extends Controller
{
    private $billModel;

    public function __construct()
    {
        Auth::requireLogin();
        Auth::requireRole('association_admin');

        $this->billModel = new MonthlyBillModel();
    }

    public function index()
{
    $associationId = $_SESSION['auth']['association_id'];

    // Bills
    $bills = $this->billModel->getAll($associationId);

    // Association (IMPORTANT)
    $associationModel = new Association();
    $association = $associationModel->find($associationId);

    $this->view('monthly_bills/index', [
        'bills' => $bills,
        'association' => $association
    ]);
}

   public function create()
{
    $associationId = $_SESSION['auth']['association_id'];

    $associationModel = new Association();
    $association = $associationModel->find($associationId);

    $this->view('monthly_bills/create', [
        'association' => $association
    ]);
}
    public function store()
    {
        $this->billModel->create(
            $_SESSION['auth']['association_id'],
            $_POST
        );

        header('Location: /habitract_webapp/public/index.php/association/monthly-bills');
        exit;
    }
}