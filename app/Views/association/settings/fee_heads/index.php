<?php require_once __DIR__ . '/../../../layouts/header.php'; ?>

<div class="max-w-6xl mx-auto px-6 py-8">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Fee Heads
        </h1>

        <a href="/habitract_webapp/public/association/settings/fee-heads/create"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
            + Add Fee Head
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-600">
                        Fee Name
                    </th>
                    <th class="px-6 py-3 text-right font-medium text-gray-600">
                        Amount (₹)
                    </th>
                    <th class="px-6 py-3 text-center font-medium text-gray-600">
                        Periodicity
                    </th>
                    <th class="px-6 py-3 text-center font-medium text-gray-600">
                        Status
                    </th>
                    <th class="px-6 py-3 text-center font-medium text-gray-600">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y">

            <?php if (!empty($feeHeads)): ?>
                <?php foreach ($feeHeads as $feeHead): ?>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-800">
                            <?= htmlspecialchars($feeHead['name']) ?>
                        </td>

                        <td class="px-6 py-4 text-right text-gray-800">
                            <?= number_format($feeHead['amount'], 2) ?>
                        </td>

                        <td class="px-6 py-4 text-center text-gray-700">
                            <?= ucfirst($feeHead['periodicity']) ?>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <?php if ($feeHead['status'] === 1): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                    Active
                                </span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-700">
                                    Inactive
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="/habitract_webapp/public/association/settings/fee-heads/toggle/<?= $feeHead['id'] ?>"
                               class="text-blue-600 hover:underline font-medium">
                                Toggle
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php else: ?>

                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">
                        No Fee Heads Found
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>
        </table>

    </div>
</div>

<?php require_once __DIR__ . '/../../../layouts/footer.php'; ?>