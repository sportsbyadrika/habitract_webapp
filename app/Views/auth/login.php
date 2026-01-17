<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Association SAAS | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center">

<div class="bg-white rounded-xl shadow-xl w-full max-w-md p-8">

    <!-- Title -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Association SAAS
        </h1>
        <p class="text-gray-500 mt-1">
            Sign in to your dashboard
        </p>
    </div>

    <!-- Login Form -->
    <form method="post" action="/habitract_webapp/public/index.php/login" class="space-y-5"
    onsubmit="this.querySelector('button').disabled=true; this.querySelector('button').innerText='Logging in...';">

        <!-- CSRF -->
        <input type="hidden" name="csrf" value="<?= Security::csrfToken() ?>">

        <!-- Username -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Username / Email
            </label>
            <input
                type="text"
                name="identity"
                required
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter username or email">
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Password
            </label>
            <input
                type="password"
                name="password"
                required
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter password">
        </div>

        <!-- Login Button -->
        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition">
            Login
        </button>
    </form>
   

    <!-- Error Message -->
<?php if (!empty($_GET['error'])): ?>
    <div class="mt-4 text-sm text-red-600 text-center">
        Invalid username or password
    </div>
<?php endif; ?>

<!-- Register & Forgot -->
<div class="text-center mt-6 space-y-2">

    <a href="/habitract_webapp/public/index.php/register"
       class="text-blue-600 font-semibold hover:underline">
        Register your Association
    </a>

    <div>
        <a href="/habitract_webapp/public/index.php/forgot-password"
           class="text-sm text-gray-500 hover:underline">
            Forgot password?
        </a>
    </div>

</div>
<hr class="my-4 border-gray-200">
<!-- Footer -->
<div class="text-center text-xs text-gray-400 mt-6">
    © <?= date('Y') ?> Association SAAS
</div>

</body>
</html>