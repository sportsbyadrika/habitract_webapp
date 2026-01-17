<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP | Association SAAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center">

<div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6">

    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Verify OTP</h1>
        <p class="text-gray-500 text-sm mt-1">
            OTP sent to<br><strong>
        <?= htmlspecialchars(substr($email, 0, 3)) ?>***@<?= explode('@', $email)[1] ?>
    </strong>
        </p>
    </div>

  <form method="post" action="/habitract_webapp/public/index.php/verify-otp">
    <input type="hidden" name="csrf" value="<?= Security::csrfToken() ?>">

    <label class="block text-sm font-medium text-gray-600 mb-1">
        Enter OTP
    </label>

    <input
        type="text"
        name="otp"
        maxlength="6"
        required
        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
        placeholder="Enter 6-digit OTP"
    >

    <!-- ✅ DEV OTP DISPLAY (LOCAL ONLY) -->
    <?php if (isset($_SESSION['dev_otp'])): ?>
        <p class="text-xs text-gray-400 mt-2">
            DEV OTP: <?= htmlspecialchars($_SESSION['dev_otp']) ?>
        </p>
    <?php endif; ?>

    <button
        type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg mt-4"
    >
        Verify OTP
    </button>
</form>

    <div class="text-center text-xs text-gray-400 mt-6">
        © <?= date('Y') ?> Association SAAS
    </div>

</div>

</body>
</html>
