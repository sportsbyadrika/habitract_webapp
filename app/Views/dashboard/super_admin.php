<?php
use App\Core\Security;
ob_start();
?>
<div class="space-y-6">
    <h1 class="text-2xl font-bold">Super Admin Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-4 border">
            <p class="text-sm text-slate-600">Total Associations</p>
            <p class="text-3xl font-bold"><?= (int) $totalAssociations; ?></p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border">
            <p class="text-sm text-slate-600">Active Associations</p>
            <p class="text-3xl font-bold text-green-600"><?= (int) $activeAssociations; ?></p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border">
            <p class="text-sm text-slate-600">Inactive Associations</p>
            <p class="text-3xl font-bold text-amber-600"><?= (int) $inactiveAssociations; ?></p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border">
            <p class="text-sm text-slate-600">Association Admins</p>
            <p class="text-3xl font-bold text-indigo-600"><?= (int) $totalAdmins; ?></p>
        </div>
    </div>
    <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-2">Manage Associations</h2>
        <p class="text-sm text-slate-700">Use the associations controller and model to add new associations, update service end dates, and assign admin users.</p>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
