<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Expected variables from controller:
 * $categories  -> array of member categories
 * $fee_heads   -> array of fee heads
 * $mapped      -> array [category_id => [fee_head_id, fee_head_id]]
 */
$mapped = $mapped ?? [];
$fee_heads = $fee_heads ?? [];
$categories = $categories ?? [];
?>

<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md">

        <!-- Header -->
        <div class="bg-blue-600 rounded-t-xl px-6 py-4">
            <h2 class="text-white text-lg font-semibold">Category Fee Mapping</h2>
        </div>

        <!-- Flash Messages -->
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="mx-6 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="mx-6 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST"
              action="<?= BASE_URL ?>/association/settings/category-fee-mapping/store"
              class="p-6 space-y-6">

            <!-- Member Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Member Category
                </label>
                <select name="category_id"
                        required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>">
                            <?= ucfirst($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Fee Heads -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Fee Heads
                </label>

                <div class="border border-gray-200 rounded-lg p-4 space-y-3">

                    <?php if (empty($fee_heads)): ?>
                        <p class="text-sm text-gray-500">No fee heads available</p>
                    <?php endif; ?>

                    <?php foreach ($fee_heads as $fee): ?>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox"
                                   name="fee_heads[]"
                                   value="<?= $fee->id ?>"
                                   class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded">

                            <div class="text-sm">
                                <div class="font-medium text-gray-800">
                                    <?= $fee->name ?>
                                </div>
                                <div class="text-gray-500">
                                    ₹<?= number_format($fee->amount, 2) ?>
                                    /
                                    <?= ucfirst($fee->periodicity) ?>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-medium">
                    Save Mapping
                </button>
            </div>

        </form>
    </div>
</div>