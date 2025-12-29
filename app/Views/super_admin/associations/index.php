<div class="p-6">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Associations</h2>
        
    </div>

    <form class="flex gap-3 mb-4">
        <input type="text" name="search" placeholder="Search"
               class="border px-3 py-2 rounded">

        <select name="status" class="border px-3 py-2 rounded">
            <option value="">All</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>

        <button class="bg-gray-700 text-white px-4 px-4 rounded">Filter</button>
    </form>

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 border-b">Name</th>
                    <th class="text-left px-4 py-3 border-b">District</th>
                    <th class="text-left px-4 py-3 border-b">Status</th>
                    <th class="text-center px-4 py-3 border-b">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($associations)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            No associations found
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($associations as $a): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 border-b">
                            <?= htmlspecialchars($a['name']) ?>
                        </td>

                        <td class="px-4 py-3 border-b">
                            <?= htmlspecialchars($a['district_name']) ?>
                        </td>

                        <td class="px-4 py-3 border-b">
                            <?php if ($a['status'] == 1): ?>
                                <span class="text-green-600 font-medium">Active</span>
                            <?php else: ?>
                                <span class="text-red-600 font-medium">Inactive</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-4 py-3 border-b text-center space-x-3">
                            <a
                                href="/habitract_webapp/public/index.php/super-admin/associations/edit?id=<?= $a['id'] ?>"
                                class="text-blue-600 hover:underline"
                            >
                                Edit
                            </a>

                            <?php if ($a['status'] == 1): ?>
                                <form
                                    method="post"
                                    action="/habitract_webapp/public/index.php/super-admin/associations/deactivate"
                                    class="inline"
                                    onsubmit="return confirm('Deactivate this association?')"
                                >
                                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                    <button class="text-red-600 hover:underline">
                                       / Deactivate
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>