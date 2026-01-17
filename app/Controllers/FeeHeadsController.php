<?php
class FeeHeadsController extends Controller
{
    public function index()
    {
       $sql = "SELECT * FROM fee_heads ORDER BY id DESC";
        $stmt = Database::query($sql);
        $feeHeads = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('association/settings/fee_heads/index', [
            'feeHeads' => $feeHeads
        ]);
    }
    public function create()
    {
        $this->view('association/settings/fee_heads/create');
    }

    public function store()
    {
         $sql = "
            INSERT INTO fee_heads (name, amount, periodicity, status)
            VALUES (?, ?, ?, 1)
        ";

        Database::query($sql, [
            $_POST['name'],
            $_POST['amount'],
            $_POST['periodicity']
        ]);

        header('Location: /association/settings/fee-heads');
        exit;
    }
}
