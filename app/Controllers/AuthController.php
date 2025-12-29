<?php
class AuthController extends Controller {
   public function loginForm()
{
    require __DIR__ . '/../Views/auth/login.php';
}
    public function login() {
        
    if (!Security::verifyCsrf($_POST['csrf'])) {
        exit('CSRF validation failed');
    }
    $user = User::findByUsername($_POST['username']);

    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        $_SESSION['user'] = $user;

        $base = '/habitract_webapp/public/index.php';

        switch ($user['user_type']) {
            case 'super_admin':
                header("Location: $base/super-admin/dashboard");
                break;

            case 'association_admin':
                header("Location: $base/association-admin/dashboard");
                break;

            default:
                header("Location: $base/member/dashboard");
        }
        exit;
    }
    exit('Invalid credentials');
}
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }
}