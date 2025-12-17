<?php
use App\Core\Security;
ob_start();
?>
<div class="space-y-6">
    <h1 class="text-2xl font-bold">Association Admin Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-4 border">
            <p class="text-sm text-slate-600">Association</p>
            <p class="text-xl font-semibold"><?= Security::sanitize($association['name']); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border">
            <p class="text-sm text-slate-600">Association Code</p>
            <p class="text-xl font-semibold text-indigo-600"><?= Security::sanitize($association['association_code']); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border">
            <p class="text-sm text-slate-600">Members</p>
            <p class="text-3xl font-bold"><?= (int) $memberCount; ?></p>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4 border">
        <h2 class="text-lg font-semibold mb-2">Validity</h2>
        <p class="text-sm text-slate-700">Valid from <?= Security::sanitize($association['valid_from']); ?> to <?= Security::sanitize($association['valid_to']); ?>. Service ends on <?= Security::sanitize($association['service_end_date']); ?>.</p>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
