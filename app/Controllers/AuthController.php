<?php
class AuthController extends Controller {
   public function loginForm()
{
    require __DIR__ . '/../Views/auth/login.php';
}
    public function login()
{
    if (!Security::verifyCsrf($_POST['csrf'])) {
        exit('CSRF validation failed');
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $base = '/habitract_webapp/public/index.php';

   
    $user = User::findByUsername($username);

    if ($user && password_verify($password, $user['password_hash'])) {

    $_SESSION['user'] = [
        'id'   => $user['id'],
        'email' => $user['email'],
        'role' => 'super_admin'
    ];

    header("Location: $base/super-admin/dashboard");
    exit;
}

    
   $associationAdmin = AssociationAdmin::findByEmail($username);

if ($associationAdmin && password_verify($password, $associationAdmin['password'])) {

    $_SESSION['auth'] = [
        'id'             => $associationAdmin['id'],
        'role'           => 'association_admin',
        'association_id' => $associationAdmin['association_id']
    ];

    header("Location: $base/association/dashboard");
    exit;
}


    
    $_SESSION['error'] = 'Invalid username or password';
    header("Location: $base/login");
    exit;
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