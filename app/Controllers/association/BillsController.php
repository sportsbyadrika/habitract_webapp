<?php

class BillsController extends Controller
{
     private $billModel;
    private $billItemModel;
    private $categoryFeeHeadModel;
    private $memberModel;
    private $memberCategoryModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->billModel             = new BillModel();
        $this->billItemModel         = new BillItemModel();
        $this->categoryFeeHeadModel  = new CategoryFeeHeadModel();
        $this->memberModel           = new MemberModel();
        $this->memberCategoryModel   = new MemberCategoryModel();
    }

    /**
     * Bills list page
     */
    public function index()
    {
        $bills = $this->billModel->getLatestBills();
        require __DIR__ . '/../../Views/association/bills/index.php';
    }

    /**
     * Generate bills
     */
    public function generate()
{
    $associationId = $_SESSION['auth']['association_id'] ?? null;

    if (!$associationId) {
        $_SESSION['error'] = 'Invalid session';
        header('Location: ' . BASE_URL . '/association/bills');
        exit;
    }

    // ✅ 1. HANDLE GET REQUEST (SHOW PAGE)
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $categories = $this->memberCategoryModel->getActiveCategories();

        require __DIR__ . '/../../Views/association/bills/generate.php';
        return;
    }

    // ✅ 2. HANDLE POST REQUEST (GENERATE BILLS)
    $categoryId = $_POST['category_id'] ?? null;

    if (!$categoryId) {
        $_SESSION['error'] = 'Please select a category';
        header('Location: ' . BASE_URL . '/association/bills/generate');
        exit;
    }

    $month = (int) date('m');
    $year  = (int) date('Y');

    $members = $this->memberModel->getMembersByCategory($associationId, $categoryId);
    $feeHeads = $this->categoryFeeHeadModel->getFeeHeadsByCategory($categoryId);

    if (empty($members) || empty($feeHeads)) {
        $_SESSION['error'] = 'Members or fee heads missing';
        header('Location: ' . BASE_URL . '/association/bills/generate');
        exit;
    }

    $generated = 0;

    foreach ($members as $member) {

        if ($this->billModel->exists($member->id, $month, $year)) {
            continue;
        }

        $billId = $this->billModel->create([
            'member_id'          => $member->id,
            'category_id'        => $categoryId,
            'bill_month'         => $month,
            'bill_year'          => $year,
            'due_date'           => date('Y-m-15'),
            'total_amount'       => 0,
            'outstanding_amount' => 0
        ]);

        if (!$billId) {
            continue;
        }

        $total = 0;

        foreach ($feeHeads as $fee) {
            $amount = (float) $fee['amount'];

            $this->billItemModel->add(
                $billId,
                'fee',
                $fee['fee_head_name'],
                $amount
            );

            $total += $amount;
        }

        $this->billModel->updateTotals($billId, $total);
        $generated++;
    }

    $_SESSION['success'] = $generated . ' bills generated successfully';
    header('Location: ' . BASE_URL . '/association/bills');
    exit;
}
public function show()
{
    $billId = $_GET['id'] ?? null;

    if (!$billId) {
        header('Location: ' . BASE_URL . '/association/bills');
        exit;
    }

    $bill  = $this->billModel->getBillById($billId);
    $items = $this->billItemModel->getItemsByBillId($billId);

    require __DIR__ . '/../../Views/association/bills/view.php';
}


}
