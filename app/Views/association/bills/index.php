<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Bills</title>

    <!-- Tailwind (since your navbar uses it) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #f5f6f8;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- ✅ ASSOCIATION ADMIN NAVBAR -->
<?php include __DIR__ . '/../../layouts/navbar_association_admin.php'; ?>

<!-- PAGE CONTENT -->
<div class="max-w-5xl mx-auto px-4 py-4">

    <!-- HEADER -->
    <div class="mb-3">
        <h1 class="text-lg font-semibold text-gray-800">
            Monthly Bills
        </h1>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-md shadow-sm overflow-hidden">

        <table class="w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-3 py-2 text-left">Member</th>
                    <th class="px-3 py-2 text-left">House</th>
                    <th class="px-3 py-2 text-left">Month</th>
                    <th class="px-3 py-2 text-center">Total (₹)</th>
                    <th class="px-3 py-2 text-center">Status</th>
                    <th class="px-3 py-2 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="text-sm text-gray-800">
            <?php if (empty($bills)): ?>
                <tr>
                    <td colspan="6" class="px-3 py-4 text-center text-gray-500">
                        No bills found
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($bills as $bill): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-3 py-2">
                            <?= htmlspecialchars($bill['owner_name']) ?>
                        </td>
                        <td class="px-3 py-2">
                            <?= htmlspecialchars($bill['house_number']) ?>
                        </td>
                        <td class="px-3 py-2">
                            <?= $bill['bill_month'] ?>/<?= $bill['bill_year'] ?>
                        </td>
                        <td class="px-3 py-2 text-center font-medium">
    ₹<?= number_format($bill['total_amount'], 2) ?>
</td>

<td class="px-3 py-2 text-center">
    <span class="inline-block rounded-full bg-gray-200 text-gray-800 text-xs px-2 py-0.5">
        <?= ucfirst($bill['status']) ?>
    </span>
</td>
                        <td class="px-3 py-2 text-center">
                           <a href="<?= BASE_URL ?>/association/bills/view?id=<?= $bill['id'] ?>">View</a>
                               
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
