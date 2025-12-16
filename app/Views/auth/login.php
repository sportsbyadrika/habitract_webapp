<?php
ob_start();
?>
<div class="max-w-lg mx-auto mt-10 bg-white shadow-sm rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Sign in</h1>
    <?php if (!empty($error)): ?>
        <div class="mb-4 rounded bg-red-50 text-red-700 px-4 py-3">
            <?= \App\Core\Security::sanitize($error); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="/login" class="space-y-4">
        <input type="hidden" name="<?= $config['security']['csrf_token_name']; ?>" value="<?= $csrfToken; ?>">
        <div>
            <label class="block text-sm font-medium text-slate-700">Username</label>
            <input required name="username" class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-500" type="text" autocomplete="username">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Password</label>
            <input required name="password" class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-500" type="password" autocomplete="current-password">
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Login</button>
    </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
