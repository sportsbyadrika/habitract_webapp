<?php

require_once __DIR__ . '/../Core/Database.php';

class SubscriptionController
{
    public function index()
    {
        require __DIR__ . '/../Views/subscription/subscribe.php';
    }
public function process()
{
    session_start();

    if (empty($_SESSION['auth']['association_id'])) {
        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }

    $associationId = $_SESSION['auth']['association_id'];

    $pdo = Database::getInstance();

    $stmt = $pdo->prepare("
        UPDATE associations
        SET 
            subscription_status = 'active',
            plan_id = 1,
            last_payment_at = NOW(),
            trial_end_date = NULL
        WHERE id = ?
    ");

    $stmt->execute([$associationId]);

    // redirect back with success flag
    header("Location: /habitract_webapp/public/index.php/subscribe?success=1");
    exit;
}

}