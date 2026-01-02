<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/navbar.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<h1 class="text-2xl font-semibold mb-6">Association Admins</h1>

<!-- Add Admin Card -->
<div class="bg-white p-6 rounded shadow mb-8">
    <h2 class="text-lg font-medium mb-4">Add Association Admin</h2>

    <form method="post"
          action="/habitract_webapp/public/index.php/super-admin/association-admins/store"
          class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <input type="hidden" name="association_id" value="<?= $associationId ?>">

        <input type="text" name="name" placeholder="Name" required class="border p-2 rounded">
        <input type="email" name="email" placeholder="Email" required class="border p-2 rounded">
        <input type="text" name="mobile" placeholder="Mobile" required class="border p-2 rounded">
        <input type="text" name="designation" placeholder="Designation" required class="border p-2 rounded">
        <input type="password" name="password" placeholder="Password" required class="border p-2 rounded">

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Add Admin
        </button>
    </form>
</div>

<!-- Admin List -->
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-lg font-medium mb-4">Existing Admins</h2>

    <table class="w-full border-collapse">
        <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Mobile</th>
            <th class="p-2 border">Designation</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($admins)): ?>
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-500">
                    No admins assigned yet.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td class="p-2 border"><?= htmlspecialchars($admin['name']) ?></td>
                    <td class="p-2 border"><?= htmlspecialchars($admin['email']) ?></td>
                    <td class="p-2 border"><?= htmlspecialchars($admin['mobile']) ?></td>
                    <td class="p-2 border"><?= htmlspecialchars($admin['designation']) ?></td>
                    <td class="p-2 border">
                        <?= $admin['is_active'] ? 'Active' : 'Inactive' ?>
                    </td>
                    <td class="p-2 border">
                        <form method="post"
                              action="/habitract_webapp/public/index.php/super-admin/association-admins/toggle"
                              class="inline">
                            <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                            <input type="hidden" name="status" value="<?= $admin['is_active'] ? 0 : 1 ?>">
                            <button class="text-red-600 hover:underline">
                                <?= $admin['is_active'] ? 'Deactivate' : 'Activate' ?>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
