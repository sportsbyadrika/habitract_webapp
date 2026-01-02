
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/navbar.php'; ?>


    <!-- Filters -->
    <form method="get" class="flex gap-3 mb-4">
        <input
            type="text"
            name="search"
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
            placeholder="Search association"
            class="border px-3 py-2 rounded w-64"
        >

        <select name="status" class="border px-3 py-2 rounded">
    <option value="">All</option>

    <option value="1" <?= ($_GET['status'] ?? '') === '1' ? 'selected' : '' ?>>
        Active
    </option>

    <option value="2" <?= ($_GET['status'] ?? '') === '2' ? 'selected' : '' ?>>
        Suspended
    </option>

    <option value="0" <?= ($_GET['status'] ?? '') === '0' ? 'selected' : '' ?>>
        Deactivated
    </option>
</select>
        <button class="bg-gray-700 text-white px-4 py-2 rounded">
            Filter
        </button>
    </form>

    <!-- Table -->
    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 border-b">Name</th>
                    <th class="text-left px-4 py-3 border-b">State</th>
                    <th class="text-left px-4 py-3 border-b">District</th>
                    <th class="text-left px-4 py-3 border-b">Status</th>
                    <th class="text-center px-4 py-3 border-b">Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if (empty($associations)): ?>
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">
                        No associations found
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($associations as $a): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 border-b">
                            <?= htmlspecialchars($a['name']) ?>
                        </td>

                        <td class="px-4 py-3 border-b">
                            <?= htmlspecialchars($a['state_name']) ?>
                        </td>

                        <td class="px-4 py-3 border-b">
                            <?= htmlspecialchars($a['district_name']) ?>
                        </td>

                        <td class="px-4 py-3 border-b">
                           <?php if ($a['status'] == 1): ?>
    <span class="text-green-600 font-medium">Active</span>
<?php elseif ($a['status'] == 2): ?>
    <span class="text-orange-600 font-medium">Suspended</span>
<?php else: ?>
    <span class="text-red-600 font-medium">Deactivated</span>
<?php endif; ?>

                        </td>

                        <td class="px-4 py-3 border-b text-center space-x-3">

                             <!-- Edit always allowed -->
    <a href="/habitract_webapp/public/index.php/super-admin/associations/edit?id=<?= $a['id'] ?>"
       class="text-blue-600 hover:underline">
        Edit
    </a>
    <a href="/habitract_webapp/public/index.php/super-admin/association-admins?association_id=<?= $a['id'] ?>">
    Manage Admins
    </a>
    <?php if ($a['status'] == 1): ?>
        <!-- ACTIVE → SUSPEND -->
        <form method="post"
              action="/habitract_webapp/public/index.php/super-admin/associations/suspend"
              class="inline"
              onsubmit="return confirm('Suspend this association?')">
            <input type="hidden" name="id" value="<?= $a['id'] ?>">
            <button class="text-orange-600 hover:underline">
                Suspend
            </button>
        </form>

        <!-- ACTIVE → DEACTIVATE -->
        <form method="post"
              action="/habitract_webapp/public/index.php/super-admin/associations/deactivate"
              class="inline"
              onsubmit="return confirm('Deactivate permanently? This cannot be undone.')">
            <input type="hidden" name="id" value="<?= $a['id'] ?>">
            <button class="text-red-600 hover:underline">
                Deactivate
            </button>
        </form>

    <?php elseif ($a['status'] == 2): ?>
        <!-- SUSPENDED → ACTIVATE -->
        <form method="post"
              action="/habitract_webapp/public/index.php/super-admin/associations/activate"
              class="inline"
              onsubmit="return confirm('Activate this association?')">
            <input type="hidden" name="id" value="<?= $a['id'] ?>">
            <button class="text-green-600 hover:underline">
                Activate
            </button>
        </form>

        <!-- SUSPENDED → DEACTIVATE -->
        <form method="post"
              action="/habitract_webapp/public/index.php/super-admin/associations/deactivate"
              class="inline"
              onsubmit="return confirm('Deactivate permanently? This cannot be undone.')">
            <input type="hidden" name="id" value="<?= $a['id'] ?>">
            <button class="text-red-600 hover:underline">
                Deactivate
            </button>
        </form>

    <?php else: ?>
        <!-- DEACTIVATED -->
        <span class="text-gray-400 italic">Locked</span>
    <?php endif; ?>


                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>