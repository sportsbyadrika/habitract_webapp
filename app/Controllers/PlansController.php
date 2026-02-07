<?php

class PlansController
{
    public function contact()
    {
        require __DIR__ . '/../Views/plans/contact.php';
    }
public function submitContact()
{
    header('Content-Type: application/json');

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        echo json_encode(['status' => 'error', 'message' => 'All fields required']);
        return;
    }

    // DB connection (USE YOUR DB NAME)
    $db = new mysqli("localhost", "root", "", "association_saas");

    if ($db->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'DB connection failed']);
        return;
    }

    $stmt = $db->prepare(
        "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)"
    );

    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Query failed']);
        return;
    }

    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();

    // OPTIONAL: Email admin
    // mail("admin@yourdomain.com", "New Contact Message", $message);

    echo json_encode(['status' => 'success']);
}
}