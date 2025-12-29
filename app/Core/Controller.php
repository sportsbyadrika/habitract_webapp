<?php
class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);

        // 🔹 ONLY NAVBAR (NO HEADER)
        if (isset($_SESSION['user'])) {
            require __DIR__ . '/../Views/layouts/navbar.php';
        }

        require __DIR__ . '/../Views/' . $view . '.php';

        require __DIR__ . '/../Views/layouts/footer.php';
    }
}