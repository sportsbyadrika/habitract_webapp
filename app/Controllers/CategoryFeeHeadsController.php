<?php

class CategoryFeeHeadsController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new CategoryFeeHeadModel();
    }

    /* =========================================
       SHOW CATEGORY–FEE MAPPING PAGE
       ========================================= */
    public function index()
{
    $associationId = $_SESSION['auth']['association_id'] ?? null;

    if (!$associationId) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    $data = [];
    $data['categories'] = $this->model->getActiveCategories($associationId);
    $data['fee_heads']  = $this->model->getActiveFeeHeads($associationId);

    $selectedCategoryId = $_GET['category_id'] ?? null;
    $data['selected_category_id'] = $selectedCategoryId;

    $data['mapped'] = [];
    if ($selectedCategoryId) {
        $data['mapped'] = $this->model->getMappedByCategory((int)$selectedCategoryId);
    }

    $this->view('association/settings/category_fee_mapping', $data);
}
    /* =========================================
       SAVE CATEGORY–FEE MAPPINGS
       ========================================= */
    public function store()
{
    $categoryId = $_POST['category_id'] ?? null;
    $feeHeads   = $_POST['fee_heads'] ?? [];
    $mandatory  = $_POST['mandatory_fee_heads'] ?? [];

    if (!$categoryId) {
        $_SESSION['flash_error'] = 'Please select a member category';
        header('Location: ' . BASE_URL . '/association/settings/category-fee-mapping');
        exit;
    }

    $this->model->replaceMappings(
        (int)$categoryId,
        $feeHeads,
        $mandatory
    );

    $_SESSION['flash_success'] = 'Category fee mapping saved successfully';
    header(
        'Location: ' . BASE_URL .
        '/association/settings/category-fee-mapping?category_id=' . $categoryId
    );
    exit;
}
}