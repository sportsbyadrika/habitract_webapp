<?php

class SubscriptionGuard
{
    public static function check()
    {
        if (!isset($_SESSION['auth']) || $_SESSION['auth']['role'] !== 'association_admin') {
            header("Location: /habitract_webapp/public/index.php/login");
            exit;
        }

        $pdo = Database::getInstance();

        $stmt = $pdo->prepare("
            SELECT subscription_status, trial_end_date
            FROM associations
            WHERE id = ?
        ");
        $stmt->execute([$_SESSION['auth']['association_id']]);
        $assoc = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$assoc) {
            header("Location: /habitract_webapp/public/index.php/login");
            exit;
        }

        if ($assoc['subscription_status'] !== 'active') {
            header("Location: /habitract_webapp/public/index.php/subscribe");
            exit;
        }
    }
}