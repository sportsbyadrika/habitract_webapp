<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Association SAAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center">

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-8">
        

        <!-- Logo / Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Association SAAS</h1>
            <p class="text-gray-500 mt-1">Sign in to your dashboard</p>
        </div>

        <!-- Login Form -->
        <form method="post" action="/habitract_webapp/public/index.php/login" class="space-y-5">
            <input type="hidden" name="csrf" value="<?= Security::csrfToken() ?>">

            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Username
                </label>
                <input
                    type="text"
                    name="username"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="Enter username"
                >
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
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="Enter password"
                >
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition transform hover:-translate-y-0.5 hover:shadow-lg"
            >
                Login
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-400 mt-6">
            © <?= date('Y') ?> Association SAAS
        </div>

    </div>

    <!-- Simple animation -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }
    </style>

</body>
</html>
