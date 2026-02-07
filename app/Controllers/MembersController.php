<?php

class MembersController extends Controller
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new MemberCategoryModel();
    }

    // ==============================
    // LIST MEMBERS
    // ==============================
    public function index()
    {
        // Auth check
        if (!isset($_SESSION['auth'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $associationId = $_SESSION['auth']['association_id'] ?? null;

        if (!$associationId) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $sql = "
            SELECT 
                m.*, 
                c.name AS category_name
            FROM members m
            LEFT JOIN member_categories c ON m.member_category_id = c.id
            WHERE m.association_id = ?
            ORDER BY m.id DESC
        ";

        $stmt = Database::query($sql, [$associationId]);
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('association/members/index', [
            'members' => $members
        ]);
    }

    
    public function create()
{
    if (!isset($_SESSION['auth']) || $_SESSION['auth']['role'] !== 'association_admin') {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    $associationId = $_SESSION['auth']['association_id'];

   
    $categories = $this->categoryModel->getActiveByAssociation($associationId);

    $this->view('association/members/create', [
        'categories' => $categories
    ]);
}

    
    public function store()
    {
        $associationId = $_SESSION['auth']['association_id'] ?? null;

        if (!$associationId) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
       
        
        $countSql = "SELECT COUNT(*) AS total FROM members WHERE association_id = ?";
        $countStmt = Database::query($countSql, [$associationId]);
        $totalMembers = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        if ($totalMembers >= 250) {
            $_SESSION['error'] = "Member limit reached (Maximum 250 members allowed)";
            header("Location: " . BASE_URL . "/association/members");
            exit;
        }

        
        if (
            empty($_POST['house_number']) ||
            empty($_POST['owner_name']) ||
            empty($_POST['mobile_number']) ||
            empty($_POST['member_category_id'])
        ) {
            $_SESSION['error'] = "Please fill all required fields";
            header("Location: " . BASE_URL . "/association/members/create");
            exit;
        }

       $sql = "
INSERT INTO members (
    association_id,
    house_number,
    owner_name,
    mobile_number,
   
    occupants,
    location,
    remarks,
    member_category_id,
    membership_start_date,
    status
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
";

Database::query($sql, [
    $associationId,
    $_POST['house_number'],
    $_POST['owner_name'],
    $_POST['mobile_number'],
    $_POST['occupants'] ?? null,
    $_POST['location'] ?? null,
    $_POST['remarks'] ?? null,
    $_POST['member_category_id'],
    $_POST['date_of_join'] ?? date('Y-m-d')
]);


       $_SESSION['success'] = 'Member added successfully';
        header("Location: " . BASE_URL . "/association/members");
        exit;
    }

  
    public function edit()
    {
        $associationId = $_SESSION['auth']['association_id'] ?? null;

        if (!$associationId) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "Invalid member ID";
            header("Location: " . BASE_URL . "/association/members");
            exit;
        }

        $sql = "SELECT * FROM members WHERE id = ? AND association_id = ?";
        $stmt = Database::query($sql, [$id, $associationId]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$member) {
            $_SESSION['error'] = "Member not found";
            header("Location: " . BASE_URL . "/association/members");
            exit;
        }

        $catSql = "SELECT id, name FROM member_categories WHERE association_id = ?";
        $catStmt = Database::query($catSql, [$associationId]);
        $categories = $catStmt->fetchAll(PDO::FETCH_OBJ);

        $this->view('association/members/edit', [
            'member' => $member,
            'categories' => $categories
        ]);
    }
    public function update()
{
    // Allow only POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . BASE_URL . "/association/members");
        exit;
    }

    // Auth check
    if (!isset($_SESSION['auth'])) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    $associationId = $_SESSION['auth']['association_id'];

    // Required fields
    $memberId     = $_POST['id'] ?? null;
    $houseNumber  = $_POST['house_number'] ?? null;
    $ownerName    = $_POST['owner_name'] ?? null;
    $mobileNumber = $_POST['mobile_number'] ?? null;
    $occupants    = $_POST['occupants'] ?? null;
    $status       = $_POST['status'] ?? 1;

    if (!$memberId || !$houseNumber || !$ownerName || !$mobileNumber) {
        die("Missing required fields");
    }

    $exists = Database::query(
        "SELECT id FROM members WHERE id = ? AND association_id = ?",
        [$memberId, $associationId]
    )->fetch();

    if (!$exists) {
        die("Unauthorized access");
    }

   
    Database::query(
        "UPDATE members SET
            house_number = ?,
            owner_name = ?,
            mobile_number = ?,
            occupants = ?,
            status = ?
         WHERE id = ? AND association_id = ?",
        [
            $houseNumber,
            $ownerName,
            $mobileNumber,
            $occupants,
            $status,
            $memberId,
            $associationId
        ]
    );

    header("Location: " . BASE_URL . "/association/members");
    exit;
}

public function activate()
{
    if (!isset($_SESSION['auth'])) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    $associationId = $_SESSION['auth']['association_id'];
    $memberId = $_GET['id'] ?? null;

    if (!$memberId) {
        die("Member ID missing");
    }

    Database::query(
        "UPDATE members
         SET status = 1
         WHERE id = ? AND association_id = ?",
        [$memberId, $associationId]
    );

    header("Location: " . BASE_URL . "/association/members");
    exit;
}

public function deactivate()
{
    if (!isset($_SESSION['auth'])) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    $associationId = $_SESSION['auth']['association_id'];
    $memberId = $_GET['id'] ?? null;

    if (!$memberId) {
        die("Member ID missing");
    }

    Database::query(
        "UPDATE members
         SET status = 0
         WHERE id = ? AND association_id = ?",
        [$memberId, $associationId]
    );

    header("Location: " . BASE_URL . "/association/members");
    exit;
}
}