<?php


class MembersController extends Controller
{
    protected $memberCategory;

    public function __construct()
    {
        $this->memberCategory = new MemberCategory();
    }

    
   public function index()
{
    // 1. Auth check
    if (!isset($_SESSION['auth'])) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    // 2. Get association id from auth session
    $associationId = $_SESSION['auth']['association_id'] ?? null;

    // 3. Fetch members
    $sql = "
        SELECT 
            m.*,
            c.name AS category_name
        FROM members m
        LEFT JOIN member_categories c 
            ON m.member_category_id = c.id
        WHERE m.association_id = ?
        ORDER BY m.id DESC
    ";

    $stmt = Database::query($sql, [$associationId]);
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. Load view (same pattern as Member Categories)
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

    // Load member categories for dropdown
    $sql = "SELECT id, name FROM member_categories WHERE association_id = ?";
    $stmt = Database::query($sql, [$associationId]);
    $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
 $this->view('association/members/create', [
        'categories' => $categories  ]);
   // require VIEW_PATH . '/layouts/navbar_association_admin.php';
    //require VIEW_PATH . '/association/members/create.php';
}
    public function store()
    {
        $associationId = $_SESSION['auth']['association_id'] ?? null;
        if (!$associationId) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Basic validation
        if (
            empty($_POST['house_number']) ||
            empty($_POST['owner_name']) ||
            empty($_POST['mobile_number']) ||
            empty($_POST['member_category_id'])
        ) {
            $_SESSION['error'] = 'Please fill all required fields';
            header('Location: ' . BASE_URL . '/association/members/create');
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
                membership_start_date
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
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
        header('Location: ' . BASE_URL . '/association/members');
        exit;
    }

   
    public function edit()
{
    $associationId = $_SESSION['association_id'] ?? null;
    if (!$associationId) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        $_SESSION['error'] = 'Invalid member ID';
        header('Location: ' . BASE_URL . '/association/members');
        exit;
    }

    $sql = "
        SELECT *
        FROM members
        WHERE id = ? AND association_id = ?
    ";

    $stmt = Database::query($sql, [$id, $associationId]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$member) {
        $_SESSION['error'] = 'Member not found';
        header('Location: ' . BASE_URL . '/association/members');
        exit;
    }
        require VIEW_PATH . '/association/members/edit.php';

    }
} 
