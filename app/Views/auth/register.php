<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Association SAAS | Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center">

<div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">

    <!-- Title -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Register Association
        </h1>
        <p class="text-gray-500 mt-1">
            Create your association account
        </p>
    </div>

    <!-- Register Form -->
    <form method="post"
          action="/habitract_webapp/public/index.php/register"
          class="space-y-4"
          onsubmit="this.querySelector('button').disabled=true; this.querySelector('button').innerText='Submitting...';">

        <!-- CSRF -->
        <input type="hidden" name="csrf" value="<?= Security::csrfToken() ?>">

        <!-- Association Name -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Association Name
            </label>
            <input type="text" name="association_name" required
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                   placeholder="Eg: Green Valley Apartments">
        </div>

        <!-- Registration Number -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Registration Number
            </label>
            <input type="text" name="registration_no" required
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                   placeholder="Society / Govt registration number">
        </div>

        <!-- Admin Name -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Admin Name
            </label>
            <input type="text" name="admin_name" required
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                   placeholder="Admin full name">
        </div>

        <!-- Admin Email -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Admin Email
            </label>
            <input type="email" name="email" required
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                   placeholder="admin@example.com">
        </div>

        <!-- Admin Mobile -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Admin Mobile Number
            </label>
            <input type="tel" name="mobile" required
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                   placeholder="10-digit mobile number">
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition">
            Send OTP & Continue
        </button>
    </form>

    <!-- Back to login -->
    <div class="text-center mt-6">
        <a href="/habitract_webapp/public/index.php/login"
           class="text-sm text-gray-500 hover:underline">
            Already registered? Login
        </a>
    </div>

    <!-- Footer -->
    <div class="text-center text-xs text-gray-400 mt-6">
        © <?= date('Y') ?> Association SAAS
    </div>

</div>

</body>
</html>