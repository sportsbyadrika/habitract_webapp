<?php
// app/Views/monthly_bills/index.php
?>

<div class="max-w-7xl mx-auto px-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Monthly Bills
        </h1>

        <a href="/habitract_webapp/public/index.php/association/monthly-bills/create"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-md text-sm font-medium">
            + Add Bill
        </a>
    </div>

    <!-- Bills Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left whitespace-nowrap">
                        Bill Ref No
                    </th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">
                        Bill Date
                    </th>
                    <th class="px-4 py-3 text-left">
                        Fee Category
                    </th>
                    <th class="px-4 py-3 text-right whitespace-nowrap">
                        Amount
                    </th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">
                        Due Date
                    </th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">
                        Status
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($bills)): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            No monthly bills found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bills as $bill): ?>
                        <tr class="border-t hover:bg-gray-50">

                            <!-- Bill Ref No -->
                            <td class="px-4 py-3 font-medium whitespace-nowrap">
                                <?= htmlspecialchars($bill['demand_no']) ?>
                            </td>

                            <!-- Bill Date -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <?= date('d M Y', strtotime($bill['demand_date'])) ?>
                            </td>

                            <!-- Fee Category -->
                            <td class="px-4 py-3">
    <?= htmlspecialchars($bill['head_of_account'] ?? '—') ?>
</td>

                            <!-- Amount -->
                            <td class="px-4 py-3 text-right font-semibold whitespace-nowrap">
                                <?= number_format($bill['amount'], 2) ?>
                            </td>

                            <!-- Due Date -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <?= date('d M Y', strtotime($bill['due_date'])) ?>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    <?= $bill['status'] === 'active'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-gray-200 text-gray-700' ?>">
                                    <?= ucfirst($bill['status']) ?>
                                </span>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>