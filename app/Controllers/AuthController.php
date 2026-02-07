<?php

class AuthController extends Controller
{
    /* ==========================
       LOGIN
    ========================== */

    public function loginForm()
    {
        require __DIR__ . '/../Views/auth/login.php';
    }

  public function login()
{
    session_start();

    $identity = trim($_POST['identity'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($identity === '' || $password === '') {
        header("Location: /habitract_webapp/public/index.php/login?error=1");
        exit;
    }

    $pdo = Database::getInstance();

    /* ================= SUPER ADMIN ================= */
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$identity]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['auth'] = [
            'id'   => $user['id'],
            'role' => 'super_admin'
        ];

        header("Location: /habitract_webapp/public/index.php/super-admin/dashboard");
        exit;
    }

    /* ============ ASSOCIATION ADMIN ============ */
    $stmt = $pdo->prepare("
        SELECT * FROM association_admins
        WHERE email = ? AND is_active = 1
    ");
    $stmt->execute([$identity]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['auth'] = [
            'id'             => $admin['id'],
            'association_id' => $admin['association_id'],
            'role'           => 'association_admin'
        ];

        // ALWAYS go to dashboard
       
    header("Location: " . BASE_URL . "/association/dashboard");
    exit;
    }

    // ❌ Login failed
    header("Location: /habitract_webapp/public/index.php/login?error=1");
    exit;
}
    /* ==========================
       REGISTER ASSOCIATION
    ========================== */

    public function registerForm()
    {
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function register()
{
    if (!Security::verifyCsrf($_POST['csrf'] ?? '')) {
        exit('CSRF validation failed');
    }

    $data = [
        'association_name' => trim($_POST['association_name']),
        'registration_no'  => trim($_POST['registration_no']),
        'admin_name'       => trim($_POST['admin_name']),
        'email'            => trim($_POST['email']),
        'mobile'           => trim($_POST['mobile']),
    ];

    foreach ($data as $value) {
        if ($value === '') {
            header("Location: /habitract_webapp/public/index.php/register?error=1");
            exit;
        }
    }

    $otp = rand(100000, 999999);
    $expires = time() + 600; // 10 minutes

    $_SESSION['registration'] = $data;
    $_SESSION['registration_otp'] = password_hash($otp, PASSWORD_DEFAULT);
    $_SESSION['otp_expires'] = $expires;

    /*mail(
        $data['email'],
        "Association Registration OTP",
        "Your OTP is: $otp\nValid for 10 minutes."
    );*/
    $_SESSION['dev_otp'] = $otp;
    

    header("Location: /habitract_webapp/public/index.php/verify-otp");
    exit;
}   
public function verifyOtpForm()
{
    if (!isset($_SESSION['registration']['email'])) {
        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }

    $email = $_SESSION['registration']['email'];
    require __DIR__ . '/../Views/auth/verify_otp.php';
}
public function verifyOtp()
{
    

    $otp = $_POST['otp'] ?? '';

    if (
        !isset($_SESSION['registration_otp'], $_SESSION['otp_expires']) ||
        time() > $_SESSION['otp_expires']
    ) {
        header("Location: /habitract_webapp/public/index.php/register?error=otp_expired");
        exit;
    }

    if (!password_verify($otp, $_SESSION['registration_otp'])) {
        header("Location: /habitract_webapp/public/index.php/verify-otp?error=1");
        exit;
    }

    
    $_SESSION['otp_verified']   = true;
    $_SESSION['password_email'] = $_SESSION['registration']['email'];

    
    header("Location: /habitract_webapp/public/index.php/set-password");
    exit;
}
public function setPasswordForm()
{
   

    // Allow success page reload
    if (isset($_GET['success'])) {
        require __DIR__ . '/../Views/auth/set_password.php';
        return;
    }

    // Only allow if OTP verified
    if (!isset($_SESSION['otp_verified']) || !isset($_SESSION['registration'])) {
        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }

    // Store email for view
    $_SESSION['password_email'] = $_SESSION['registration']['email'];

    require __DIR__ . '/../Views/auth/set_password.php';
}
public function setPassword()
{
    session_start();

    // Allow success page without otp_verified
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        return;
    }

    if (
        !isset($_SESSION['otp_verified']) ||
        !isset($_SESSION['registration'])
    ) {
        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }

    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if ($password === '' || $password !== $confirm) {
        header("Location: /habitract_webapp/public/index.php/set-password?error=1");
        exit;
    }

    $data = $_SESSION['registration'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $pdo = Database::getInstance();

    // Create association
    $stmt = $pdo->prepare(
        "INSERT INTO associations (name, association_code, district_id, status, created_at)
         VALUES (?, ?, 1, 1, NOW())"
    );
    $stmt->execute([
        $data['association_name'],
        $data['registration_no']
    ]);

    $associationId = $pdo->lastInsertId();

    // Create admin
    $stmt = $pdo->prepare(
        "INSERT INTO association_admins
         (association_id, name, email, mobile, password, is_active, created_at)
         VALUES (?, ?, ?, ?, ?, 1, NOW())"
    );
    $stmt->execute([
        $associationId,
        $data['admin_name'],
        $data['email'],
        $data['mobile'],
        $hash
    ]);

    // Cleanup
    $_SESSION['password_email'] = $data['email'];

    unset(
        $_SESSION['registration'],
        $_SESSION['registration_otp'],
        $_SESSION['otp_expires'],
        $_SESSION['otp_verified']
    );

    
    header("Location: /habitract_webapp/public/index.php/set-password?success=1");
    exit;
}
public function forgotPasswordForm()
{
    require __DIR__ . '/../Views/auth/forgot_password.php';
}
public function sendForgotOtp()
{
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        header("Location: /habitract_webapp/public/index.php/forgot-password?error=1");
        exit;
    }

    $pdo = Database::getInstance();

    // ONLY association admins
    $stmt = $pdo->prepare(
        "SELECT id 
         FROM association_admins 
         WHERE email = ? AND is_active = 1"
    );
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if (!$admin) {
        // email not found or inactive
        header("Location: /habitract_webapp/public/index.php/forgot-password?error=notfound");
        exit;
    }

    // Generate OTP
    $otp = rand(100000, 999999);

    $_SESSION['forgot_email'] = $email;
    $_SESSION['forgot_otp'] = password_hash($otp, PASSWORD_DEFAULT);
    $_SESSION['forgot_otp_expires'] = time() + 600; // 10 minutes

    // mail($email, "Password Reset OTP", "Your OTP is $otp");
    $_SESSION['dev_otp'] = $otp; // dev/testing

    header("Location: /habitract_webapp/public/index.php/forgot-verify-otp");
    exit;
}
public function forgotVerifyOtpForm()
{
    if (!isset($_SESSION['forgot_email'])) {
        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }

    require __DIR__ . '/../Views/auth/forgot_verify_otp.php';
}
public function forgotVerifyOtp()
{
    $otp = $_POST['otp'] ?? '';

    if (
        !isset($_SESSION['forgot_otp'], $_SESSION['forgot_otp_expires']) ||
        time() > $_SESSION['forgot_otp_expires']
    ) {
        header("Location: /habitract_webapp/public/index.php/forgot-password?error=expired");
        exit;
    }

    if (!password_verify($otp, $_SESSION['forgot_otp'])) {
        header("Location: /habitract_webapp/public/index.php/forgot-verify-otp?error=1");
        exit;
    }

    $_SESSION['forgot_verified'] = true;

    header("Location: /habitract_webapp/public/index.php/forgot-set-password");
    exit;
}
public function resetPasswordForm()
{
    if (!isset($_SESSION['forgot_verified'])) {
        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }

    require __DIR__ . '/../Views/auth/reset_password.php';
}
public function resetPassword()
{
    if (!isset($_SESSION['forgot_verified'])) {
        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }

    $password = $_POST['password'] ?? '';

    if ($password === '') {
        header("Location: /habitract_webapp/public/index.php/reset-password?error=1");
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->execute([$hash, $_SESSION['forgot_email']]);

    unset(
        $_SESSION['forgot_email'],
        $_SESSION['forgot_otp'],
        $_SESSION['forgot_otp_expires'],
        $_SESSION['forgot_verified']
    );

    header("Location: /habitract_webapp/public/index.php/login?reset=success");
    exit;
}
public function forgotSetPasswordForm()
{
    if (!isset($_SESSION['forgot_verified'], $_SESSION['forgot_email'])) {
        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }

    require __DIR__ . '/../Views/auth/forgot_set_password.php';
}
public function forgotSetPassword()
{
    if (!isset($_SESSION['forgot_verified'], $_SESSION['forgot_email'])) {
        header("Location: /habitract_webapp/public/index.php/login");
        exit;
    }

    $password = $_POST['password'] ?? '';

    if ($password === '') {
        header("Location: /habitract_webapp/public/index.php/forgot-set-password?error=1");
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $pdo = Database::getInstance();
    $stmt = $pdo->prepare(
        "UPDATE association_admins 
         SET password = ? 
         WHERE email = ?"
    );
    $stmt->execute([$hash, $_SESSION['forgot_email']]);

        unset(
        $_SESSION['forgot_email'],
        $_SESSION['forgot_otp'],
        $_SESSION['forgot_otp_expires'],
        $_SESSION['forgot_verified']
    );

    header("Location: /habitract_webapp/public/index.php/login?reset=success");
    exit;
}

public function logout()
{
    session_start();

    
    unset($_SESSION['auth']);

   
    session_destroy();

    header("Location: /habitract_webapp/public/index.php/login");
    exit;
}
}
