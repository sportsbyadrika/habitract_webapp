<?php
/**
 * Dashboard Card Component
 *
 * Variables:
 * $title
 * $value
 * $color
 * $icon
 */
?>

<div class="bg-white rounded-md shadow-sm p-4 border-l-2 border-<?= htmlspecialchars($color) ?>-400">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">
                <?= htmlspecialchars($title) ?>
            </p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">
                <?= $value ?>
            </p>
        </div>
        <div class="text-<?= htmlspecialchars($color) ?>-500 text-3xl">
            <?= $icon ?>
        </div>
    </div>
</div>