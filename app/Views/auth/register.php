<?php
use App\Core\Security;
ob_start();
?>
<div class="max-w-xl mx-auto mt-10 bg-white shadow-sm rounded-lg p-8 space-y-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Create User</h1>
        <a href="/super-admin/dashboard" class="text-sm text-indigo-600">Back to dashboard</a>
    </div>
    <?php if (!empty($success)): ?>
        <div class="rounded bg-green-50 text-green-700 px-4 py-3"><?= Security::sanitize($success); ?></div>
    <?php endif; ?>
    <form method="POST" action="/super-admin/register" class="space-y-4">
        <input type="hidden" name="<?= $config['security']['csrf_token_name']; ?>" value="<?= $csrfToken; ?>">
        <div>
            <label class="block text-sm font-medium text-slate-700">Username</label>
            <input required name="username" class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-500" type="text">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Email</label>
            <input required name="email" class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-500" type="email">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Password</label>
            <input required name="password" class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-500" type="password">
            <p class="text-xs text-slate-500 mt-1">Passwords are hashed with Argon2id before storage.</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">User Type</label>
            <select name="user_type" class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-500">
                <option value="super_admin">Super Admin</option>
                <option value="association_admin">Association Admin</option>
                <option value="member">Member</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Create User</button>
    </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
