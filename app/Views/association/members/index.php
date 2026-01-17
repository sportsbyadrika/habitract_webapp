<div class="sticky top-20 z-10 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between border-b">
        <h1 class="text-2xl font-semibold text-gray-800">Members</h1>

        <a href="<?= BASE_URL ?>/association/members/create"
           class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 shadow">
            + Add Member
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 mt-4">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">House Number</th>
                    <th class="p-3 text-left">Owner</th>
                    <th class="p-3 text-left">Mobile</th>
                    <th class="p-3 text-left">Occupants</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($members)): ?>
                <?php foreach ($members as $m): ?>
                    <tr class="border-t">
                        <td class="p-3"><?= htmlspecialchars($m['house_number']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($m['owner_name']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($m['mobile_number']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($m['occupants']) ?></td>
                        <td class="p-3 capitalize"><?= htmlspecialchars($m['status']) ?></td>

                        <td class="p-3 space-x-3 text-blue-600">
                            <a href="/habitract_webapp/public/index.php/association/members/edit?id=<?= $m['id'] ?>">
                                Edit
                            </a>

                            <?php if ($m['status'] === 'active'): ?>
                                <a href="/habitract_webapp/public/index.php/association/members/deactivate?id=<?= $m['id']?>"
                                   class="text-red-600">
                                    Deactivate
                                </a>
                            <?php else: ?>
                                <a href="/habitract_webapp/public/index.php/association/members/activate?id=<?= $m['id'] ?>"
                                   class="text-green-600">
                                    Activate
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        No members found.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>