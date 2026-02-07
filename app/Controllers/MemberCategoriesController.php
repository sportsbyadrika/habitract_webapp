<?php

class MemberCategoriesController extends Controller
{
    private $categoryModel;

   public function __construct()
{
    $this->categoryModel = new MemberCategoryModel();
}

    /**
     * List all member categories (Settings)
     */
    public function index()
    {
        if (!isset($_SESSION['auth'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $associationId = $_SESSION['auth']['association_id'];

        $categories = $this->categoryModel
            ->getAllByAssociation($associationId);

        $this->view(
            'association/settings/member_categories/index',
            compact('categories')
        );
    }

    /**
     * Show create form
     */
    public function create()
    {
        if (!isset($_SESSION['auth'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $this->view('association/settings/member_categories/create');
    }

    /**
     * Store new category
     */
    public function store()
    {
        if (!isset($_SESSION['auth'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        // Basic validation
        if (
    empty($_POST['name']) ||
    empty($_POST['validity_type']) ||
    empty($_POST['payment_periodicity']) ||
    !isset($_POST['amount']) || $_POST['amount'] === ''
) {
    die('Required fields are missing');
}

       $this->categoryModel->create([
    'association_id'      => $_SESSION['auth']['association_id'],
    'name'                => trim($_POST['name']),
    'validity_type'       => $_POST['validity_type'],
    'payment_periodicity' => $_POST['payment_periodicity'],
    'amount'              => $_POST['amount'],
    'description'         => $_POST['description'] ?? null,
    'is_active'           => 1   
]);

        header("Location: " . BASE_URL . "/association/settings/member-categories");
        exit;
    }

    /**
     * Activate / Deactivate category
     */
  public function deactivate()
{
    if (!isset($_SESSION['auth'])) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        die('Category ID missing');
    }

    $this->categoryModel->setActiveStatus($id, 0);

    header("Location: " . BASE_URL . "/association/settings/member-categories");
    exit;
}
public function activate()
{
    if (!isset($_SESSION['auth'])) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        die('Category ID missing');
    }

    $this->categoryModel->setActiveStatus($id, 1);

    header("Location: " . BASE_URL . "/association/settings/member-categories");
    exit;
}
}