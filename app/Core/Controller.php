<?php
class Controller
{
   protected function view($view, $data = [])
{
    extract($data);

    require __DIR__ . '/../Views/layouts/header.php';

    if (isset($_SESSION['auth'])) {
        $role = $_SESSION['auth']['role'];

        if ($role === 'association_admin') {
            require __DIR__ . '/../Views/layouts/navbar_association_admin.php';
        } else {
            // super_admin (default)
            require __DIR__ . '/../Views/layouts/navbar.php';
        }
    }

    require __DIR__ . '/../Views/' . $view . '.php';

    require __DIR__ . '/../Views/layouts/footer.php';
}
}