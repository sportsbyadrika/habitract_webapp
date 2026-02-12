<?php
$email = $_SESSION['password_email'] ?? null;

if (!$email && !isset($_GET['success'])) {
    header("Location: /habitract_webapp/public/index.php/login");
    exit;
}

$maskedEmail = $email
    ? preg_replace('/(.).*(.@.*)/', '$1***$2', htmlspecialchars($email))
    : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Association SAAS | Set Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-400 to-slate-600 flex items-center justify-center">

<div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6">

    <?php if (isset($_GET['success'])): ?>
        <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3 text-sm text-center">
            ✅ Password set successfully.<br>
            Redirecting to login...
        </div>

        <script>
            setTimeout(() => {
                window.location.href = "/habitract_webapp/public/index.php/login?registered=1";
            }, 2500);
        </script>

    <?php else: ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm text-center">
                ❌ Passwords do not match
            </div>
        <?php endif; ?>

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Set Password</h1>
            <p class="text-gray-500 text-sm mt-1">
                Create password for<br>
                <?= $maskedEmail ?>
            </p>
        </div>

        <form method="post" action="/habitract_webapp/public/index.php/set-password" class="space-y-4">

            <div>
                <label class="block text-sm text-gray-600 mb-1">New Password</label>
                <input type="password" name="password" required minlength="6"
                       class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Confirm Password</label>
                <input type="password" name="confirm_password" required minlength="6"
                       class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-slate-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                Save Password
            </button>
        </form>

    <?php endif; ?>

    <div class="text-center text-xs text-gray-400 mt-6">
        © <?= date('Y') ?> Association SAAS
    </div>
</div>

</body>
</html>