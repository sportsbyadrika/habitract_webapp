<!DOCTYPE html>
<html>
<head>
    <title>Association SAAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<nav class="bg-blue-600 px-6 py-4 text-white flex justify-between items-center">
    <!-- Left: App name -->
    <div class="font-bold text-lg">
        Association SAAS
    </div>

    <!-- Right: Logout (only after login) -->
    <div>
        <?php if (!empty($_SESSION['user'])): ?>
            <a href="/habitract_webapp/public/index.php/logout"
               class="bg-blue-500 hover:bg-blue-700 px-4 py-2 rounded text-sm transition">
                Logout
            </a>
        <?php endif; ?>
    </div>
</nav>

<!-- Page content wrapper -->
<div class="p-6">