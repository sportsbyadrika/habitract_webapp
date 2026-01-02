<?php
class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);

        require __DIR__ . '/../Views/layouts/header.php';

        if (isset($_SESSION['auth'])) {
            require __DIR__ . '/../Views/layouts/navbar.php';
        }

        require __DIR__ . '/../Views/' . $view . '.php';

        require __DIR__ . '/../Views/layouts/footer.php';
    }
}