<?php

class SuperAdminController extends Controller
{
   public function dashboard()
{
    Auth::requireRole('super_admin');

    $db = Database::getInstance();

    // Total associations
    $total = $db
        ->query("SELECT COUNT(*) FROM associations")
        ->fetchColumn();

    // Active associations (system active + valid subscription)
    $active = $db
        ->query("
            SELECT COUNT(*) 
            FROM associations 
            WHERE status = 1 
            AND subscription_status IN ('trial', 'active')
        ")
        ->fetchColumn();

    // Inactive associations (everything else)
    $inactive = $total - $active;

    // New contact messages
    $newMessages = $db
        ->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'new'")
        ->fetchColumn();

    $this->view(
        'super_admin/dashboard',
        compact('total', 'active', 'inactive', 'newMessages')
    );
}

    public function contactMessages()
    {
        Auth::requireRole('super_admin');

        // Use SAME DB class (important)
        $db = Database::getInstance();

        $messages = $db
            ->query("SELECT * FROM contact_messages ORDER BY created_at DESC")
            ->fetchAll(PDO::FETCH_ASSOC);

        // Mark all as read
        $db->query("UPDATE contact_messages SET status = 'read' WHERE status = 'new'");

        require_once __DIR__ . '/../Views/super_admin/contact_messages.php';
    }
  public function replyMessage()
{
    Auth::requireRole('super_admin');

    $id = $_GET['id'] ?? null;
    if (!$id) {
        die('Invalid request');
    }

    // ✅ Correct DB usage
    $db = Database::getInstance();

    $stmt = $db->prepare(
        "SELECT * FROM contact_messages WHERE id = ?"
    );
    $stmt->execute([$id]);
    $message = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$message) {
        die('Message not found');
    }

    // Mark as read
    $db->prepare(
        "UPDATE contact_messages SET status = 'read' WHERE id = ?"
    )->execute([$id]);

    require_once __DIR__ . '/../Views/super_admin/reply-message.php';
}
  public function sendReply()
{
    Auth::requireRole('super_admin');

    if (!isset($_POST['id'], $_POST['reply'])) {
        die('Invalid request');
    }

    $id    = (int) $_POST['id'];
    $reply = trim($_POST['reply']);

    $db = Database::getInstance();

    $stmt = $db->prepare(
        "SELECT * FROM contact_messages WHERE id = ?"
    );
    $stmt->execute([$id]);
    $message = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$message) {
        die('Message not found');
    }

    // 🔹 Try sending mail (may fail on localhost)
    @mail(
        $message['email'],
        "Reply from Association SAAS",
        $reply,
        "From: support@associationsaas.com"
    );

    // ✅ Always update status
    $db->prepare(
        "UPDATE contact_messages SET status='read' WHERE id=?"
    )->execute([$id]);

    // ✅ Show dialog on same page
    $replySent = true;

    require __DIR__ . '/../Views/super_admin/reply-message.php';
}
}

