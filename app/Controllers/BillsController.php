<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../helpers/WhatsAppService.php';

class BillsController extends Controller
{
    protected $billModel;
    protected $memberModel;
    protected $categoryFeeModel;
    protected $memberCategoryModel;
 protected $associationModel;
    public function __construct()
    {
       
        $this->billModel        = new BillModel();
        $this->memberModel      = new MemberModel();
        $this->categoryFeeModel = new CategoryFeeHeadModel();
         $this->memberCategoryModel = new MemberCategoryModel();
          $this->associationModel    = new Association();
    }
public function index()
{
    $associationId = $_SESSION['auth']['association_id'] ?? null;
    if (!$associationId) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
$data['summary'] = $this->billModel->getBillsSummary($associationId);
    // Fetch all bills for this association
    $data['bills'] = $this->billModel->getBillsByAssociation($associationId);

    $this->view('association/bills/index', $data);
}

    /* ===============================
       SHOW GENERATE BILLS PAGE
       =============================== */
    public function generate()
    {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
            return;
        }

        $associationId = $_SESSION['auth']['association_id'] ?? null;
        if (!$associationId) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $data['categories'] = $this->memberModel
            ->getCategoriesByAssociation($associationId);

        $this->view('association/bills/generate', $data);
    }
    private function shouldChargeMembershipFee(
    string $membershipStartDate,
    int $billMonth,
    int $billYear
): bool {
    $start = new DateTime($membershipStartDate);
    $bill  = new DateTime(sprintf('%04d-%02d-01', $billYear, $billMonth));

    $monthsDiff =
        ($bill->format('Y') - $start->format('Y')) * 12 +
        ($bill->format('m') - $start->format('m'));

    return $monthsDiff % 12 === 0;
}

    /* ===============================
       GENERATE BILLS (POST)
       =============================== */
    public function store()
{
    // 1️⃣ Read inputs
    $associationId = $_SESSION['auth']['association_id'] ?? null;
    $categoryId = $_POST['category_id'] ?? null;
    $billingMonthRaw = $_POST['bill_month'] ?? null; // YYYY-MM

    if (!$associationId || !$categoryId || !$billingMonthRaw) {
        $_SESSION['error'] = 'Category and billing month are required';
        header('Location: ' . BASE_URL . '/association/bills/generate');
        exit;
    }

    [$billYear, $billMonth] = explode('-', $billingMonthRaw);
    $billYear = (int)$billYear;
    $billMonth = (int)$billMonth;

    if ($this->billModel->billsExist($associationId, $categoryId, $billMonth, $billYear)) {
        $_SESSION['error'] = 'Bills already generated for this month';
        header('Location: ' . BASE_URL . '/association/bills/generate');
        exit;
    }

   
    $members = $this->memberModel->getMembersByCategory($associationId, $categoryId);
    if (empty($members)) {
        $_SESSION['error'] = 'No members found';
        header('Location: ' . BASE_URL . '/association/bills/generate');
        exit;
    }

    $category = $this->memberCategoryModel->find($categoryId);
    $feeHeads = $this->categoryFeeModel->getFeeHeadsForCategory($categoryId);

    $generatedCount = 0;

    foreach ($members as $member) {

        
        $billId = $this->billModel->createBill(
            $member->id,
            $categoryId,
            $billMonth,
            $billYear
        );

        $total = 0;

        if (!$this->billModel->hasMembershipFeeForYear($member->id, $billYear)) {
            $this->billModel->addBillItem(
                $billId,
                'membership_fee',
                'Annual Membership Fee',
                $category->amount
            );
            $total += $category->amount;
        }

        foreach ($feeHeads as $fee) {
            $this->billModel->addBillItem(
                $billId,
                'fee_head',
                $fee->name,
                $fee->amount
            );
            $total += $fee->amount;
        }

        $this->billModel->updateTotal($billId, $total);
        $generatedCount++;
    }

    $_SESSION['success'] = "Bills generated successfully for {$generatedCount} members";
    header('Location: ' . BASE_URL . '/association/bills');
    exit;
}
public function show()
{
    $associationId = $_SESSION['auth']['association_id'] ?? null;
    $billId = $_GET['id'] ?? null;

    if (!$associationId || !$billId) {
        header('Location: ' . BASE_URL . '/association/bills');
        exit;
    }

    $bill = $this->billModel->getBillById($billId, $associationId);

    if (!$bill) {
        $_SESSION['error'] = 'Bill not found';
        header('Location: ' . BASE_URL . '/association/bills');
        exit;
    }

    
    $items = $this->billModel->getBillItems($billId);

    $this->view('association/bills/show', [
        'bill'  => $bill,
        'items' => $items
    ]);
}

public function sendBillWhatsapp()
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    try {

        // 1. Read input
        $input = json_decode(file_get_contents('php://input'), true);
        $billId = $input['bill_id'] ?? null;

        if (!$billId) {
            throw new Exception('Bill ID missing');
        }

        // 2. Association check
        $associationId = $_SESSION['auth']['association_id'] ?? null;
        if (!$associationId) {
            throw new Exception('Unauthorized');
        }

        $billModel = new BillModel();
        $bill = $billModel->getBillById($billId, $associationId);

        if (!$bill) {
            throw new Exception('Bill not found');
        }

        if (empty($bill->mobile_number)) {
            throw new Exception('Member mobile number missing');
        }

        $mobile = preg_replace('/\D/', '', $bill->mobile_number);
        if (strlen($mobile) === 10) {
            $mobile = '91' . $mobile;
        }

        //  Build Chatico payload
    $payload = [
   "campaignName" => "sba_monthlybill_type1",
    "destination" => $mobile,
    "userName" => $bill->member_name,
    "source" => "Association SAAS",
   "templateParams" => [
    $bill->member_name, 
    date('M Y', mktime(0, 0, 0, $bill->bill_month, 1, $bill->bill_year)), 
    (string) number_format($bill->total_amount, 2),
    (string) $bill->payment_url,
    "ASSOCIATION SAAS- 8078794754"
]
];
        // 6. Send WhatsApp
        $whatsappService = new WhatsAppService();
        $result = $whatsappService->sendWhatsAppCampaign($payload);

      if (!isset($result['success']) || $result['success'] !== "true") {
    throw new Exception($result['message'] ?? 'Chatico API failed');

}

        // 7. Update DB ONLY after real success
        $billModel->markWhatsappSent($billId);

        echo json_encode([
            'status' => 1,
            'message' => 'WhatsApp sent successfully',
        ]);
        exit;

    } catch (Exception $e) {

        http_response_code(500);
        echo json_encode([
            'status' => 0,
            'message' => $e->getMessage(),
        ]);
        exit;
    }
}



}

