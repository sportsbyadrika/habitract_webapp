<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set New Password | Association SAAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Shared Auth CSS (same as Verify OTP page) -->
    <link rel="stylesheet" href="/habitract_webapp/public/assets/css/auth.css">
</head>
<body>

<div class="auth-container">

    <h1>Set New Password</h1>
    <p class="subtitle">
        Create a new password to secure your account
    </p>

    <?php if (isset($_GET['error'])): ?>
        <div class="message error">
            Unable to update password. Please try again.
        </div>
    <?php endif; ?>

    <form method="post" action="/habitract_webapp/public/index.php/forgot-set-password">

        <div class="form-group">
            <label>New Password</label>
            <input
                type="password"
                name="password"
                placeholder="Enter a strong password"
                required
            >
        </div>

        <button type="submit" class="btn">
            Save Password
        </button>

    </form>

    <div class="footer-links">
        <a href="/habitract_webapp/public/index.php/login">
            ← Back to Login
        </a>
    </div>

    <div class="brand">
        © <?= date('Y') ?> Association SAAS
    </div>

</div>

</body>
</html>
