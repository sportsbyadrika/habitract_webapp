<?php

class MemberCategoriesController extends Controller
{
    private $categoryModel;

   public function __construct()
{
    $this->categoryModel = new MemberCategory();
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
            'description'         => $_POST['description'] ?? null
        ]);

        header("Location: " . BASE_URL . "/association/settings/member-categories");
        exit;
    }

    /**
     * Activate / Deactivate category
     */
   public function toggleAjax()
{
    if (!isset($_SESSION['auth'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    if (!isset($_POST['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing ID']);
        exit;
    }

    $id = (int) $_POST['id'];

    $this->categoryModel->toggleStatus($id);

    echo json_encode([
        'success' => true
    ]);
    exit;
}
}