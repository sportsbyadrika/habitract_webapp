<?php

require_once __DIR__ . '/../Core/SubscriptionGuard.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Association.php';

class AssociationDashboardController extends Controller
{
    public function index()
    {
        //  Auth check
        if (
            !isset($_SESSION['auth']) ||
            $_SESSION['auth']['role'] !== 'association_admin'
        ) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        SubscriptionGuard::check();

        $associationId = $_SESSION['auth']['association_id'] ?? null;
        if (!$associationId) {
            die("Association ID missing");
        }

        
        $associationName = null;
        $associationModel = new Association();
        $association = $associationModel->find($associationId);
        $associationName = $association['name'] ?? null;

       $stmt = Database::query(
    "SELECT COUNT(*) AS total
     FROM members
     WHERE association_id = ?
     AND status = 1",
    [$associationId]
);

$totalMembers = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];

       
       $stmt = Database::query(
    "SELECT COALESCE(SUM(b.outstanding_amount), 0) AS pending
     FROM bills b
     INNER JOIN members m ON m.id = b.member_id
     WHERE m.association_id = ?
       AND b.outstanding_amount > 0",
    [$associationId]
);

$pendingDues = (float) $stmt->fetch(PDO::FETCH_ASSOC)['pending'];
        // ----------------------------------
        // 4️⃣ Load View
        // ----------------------------------
        $this->view('association/dashboard', [
            'associationName' => $associationName,
            'totalMembers'    => $totalMembers,
            'pendingDues'     => $pendingDues
        ]);
    }
}