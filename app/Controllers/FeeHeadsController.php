<?php

class FeeHeadsController extends Controller
{
    public function index()
    {
        $associationId = $_SESSION['auth']['association_id'];

        $sql = "SELECT * FROM fee_heads WHERE association_id = ? ORDER BY id DESC";
        $stmt = Database::query($sql, [$associationId]);
        $feeHeads = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('association/settings/fee_heads/index', compact('feeHeads'));
    }

    public function create()
    {
        $this->view('association/settings/fee_heads/create');
    }

   public function store()
{
    $associationId = $_SESSION['auth']['association_id'];
    $name = trim($_POST['name']);

    // 1. Check duplicate
    $checkSql = "
        SELECT id 
        FROM fee_heads 
        WHERE association_id = ? AND LOWER(name) = LOWER(?)
        LIMIT 1
    ";
    $stmt = Database::query($checkSql, [$associationId, $name]);

    if ($stmt->fetch()) {
        $_SESSION['error'] = 'Fee head already exists.';
        header('Location: /habitract_webapp/public/association/settings/fee-heads/create');
        exit;
    }

    // 2. Insert
    $sql = "
        INSERT INTO fee_heads 
        (association_id, name, amount, periodicity, is_active)
        VALUES (?, ?, ?, ?, ?)
    ";

    Database::query($sql, [
        $associationId,
        $name,
        $_POST['amount'],
        $_POST['periodicity'],
        $_POST['status'] === 'Active' ? 1 : 0
    ]);

    $_SESSION['success'] = '';
    header('Location: /habitract_webapp/public/association/settings/fee-heads');
    exit;
}
}
