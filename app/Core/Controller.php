<?php

class Controller
{
    protected function view($view, $data = [])
    {
        // 🔹 Only load association name for association_admin
        if (
            isset($_SESSION['auth']) &&
            $_SESSION['auth']['role'] === 'association_admin' &&
            isset($_SESSION['auth']['association_id'])
        ) {
            $stmt = Database::query(
                "SELECT name FROM associations WHERE id = ?",
                [$_SESSION['auth']['association_id']]
            );
            $association = $stmt->fetch(PDO::FETCH_ASSOC);
            $data['associationName'] = $association['name'] ?? null;
        }

        extract($data);

        // Header
        require __DIR__ . '/../Views/layouts/header.php';

        // Navbar selection
        if (isset($_SESSION['auth'])) {
            $role = $_SESSION['auth']['role'];

            if ($role === 'association_admin') {
                require __DIR__ . '/../Views/layouts/navbar_association_admin.php';
            } else {
                // super admin
                require __DIR__ . '/../Views/layouts/navbar.php';
            }
        }

        // Main view
        require __DIR__ . '/../Views/' . $view . '.php';

        // Footer
        require __DIR__ . '/../Views/layouts/footer.php';
    }
}