<?php

class CategoryFeeHeadsController extends Controller
{
    protected $db;

    public function __construct()
    {
        require_once __DIR__ . '/../Core/Database.php';

        // ✅ Correct: Database already handles connection internally
        $this->db = new Database();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $model = new CategoryFeeHeadModel();

        $data['categories'] = $model->getActiveCategories();
        $data['fee_heads']  = $model->getActiveFeeHeads();
        $data['mapped']     = $model->getMappedByCategory();

        $this->view('association/settings/category_fee_mapping', $data);
    }

   public function store()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $categoryId = $_POST['category_id'] ?? null;
    $feeHeads   = $_POST['fee_heads'] ?? [];

    if (!$categoryId) {
        $_SESSION['flash_error'] = 'Please select a category';
        header('Location: ' . BASE_URL . '/association/settings/category-fee-mapping');
        exit;
    }

    // ✅ Delete old mappings (CORRECT TABLE + COLUMN)
    $this->db->query(
        "DELETE FROM category_fee_heads WHERE member_category_id = ?",
        [$categoryId]
    );

    // ✅ Insert new mappings
    foreach ($feeHeads as $feeHeadId) {
        $this->db->query(
            "INSERT INTO category_fee_heads 
             (member_category_id, fee_head_id, is_mandatory)
             VALUES (?, ?, 1)",
            [$categoryId, $feeHeadId]
        );
    }

    $_SESSION['flash_success'] = 'Category fee mapping saved successfully';

    header('Location: ' . BASE_URL . '/association/settings/category-fee-mapping');
    exit;
}
}