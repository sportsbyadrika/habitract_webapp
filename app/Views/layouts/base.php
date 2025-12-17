<?php use App\Core\Security; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Security::sanitize($config['app']['name'] ?? 'Association Manager'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.11/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-900">
    <nav class="bg-white shadow-sm">
        <div class="mx-auto max-w-6xl px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="h-10 w-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">SA</div>
                <span class="font-semibold text-lg"><?= Security::sanitize($config['app']['name'] ?? 'Association Manager'); ?></span>
            </div>
            <?php if (!empty($user)): ?>
                <div class="relative">
                    <button class="flex items-center space-x-2 bg-indigo-50 px-3 py-2 rounded-full focus:outline-none">
                        <span class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">
                            <?= strtoupper(substr(Security::sanitize($user['username']), 0, 1)); ?>
                        </span>
                        <span class="text-sm font-medium"><?= Security::sanitize($user['username']); ?></span>
                    </button>
                    <div class="mt-2 bg-white shadow rounded-md absolute right-0 w-48 border">
                        <a class="block px-4 py-2 hover:bg-indigo-50" href="#">Manage Profile</a>
                        <a class="block px-4 py-2 hover:bg-indigo-50" href="/logout">Logout</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <main class="mx-auto max-w-6xl p-6">
        <?= $content ?? '' ?>
    </main>
</body>
</html>
