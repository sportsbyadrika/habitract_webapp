<?php
use App\Core\Security;
ob_start();
?>
<div class="space-y-6">
    <h1 class="text-2xl font-bold">Member Dashboard</h1>
    <?php if ($member): ?>
        <div class="bg-white rounded-lg shadow-sm p-4 border space-y-2">
            <p class="text-sm text-slate-600">Name</p>
            <p class="text-xl font-semibold"><?= Security::sanitize($member['name']); ?></p>
            <p class="text-sm text-slate-600">Member Code</p>
            <p class="font-semibold text-indigo-600"><?= Security::sanitize($member['member_code']); ?></p>
            <p class="text-sm text-slate-600">Association</p>
            <p class="font-semibold"><?= Security::sanitize($member['association_name']); ?> (<?= Security::sanitize($member['association_code']); ?>)</p>
            <p class="text-sm text-slate-600">Contact</p>
            <p class="font-semibold"><?= Security::sanitize($member['mobile_number']); ?></p>
        </div>
    <?php else: ?>
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-800">
            Member profile not found. Please contact your association administrator.
        </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
