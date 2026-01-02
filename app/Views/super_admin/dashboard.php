
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<h2 class="text-xl font-bold mb-4">Super Admin Dashboard</h2>

<div class="grid grid-cols-3 gap-4">
    <div class="bg-white p-4 shadow">
        Total Associations: <?= $total ?>
    </div>

    <div class="bg-white p-4 shadow">
        Active: <?= $active ?>
    </div>

    <div class="bg-white p-4 shadow">
        Inactive: <?= $inactive ?>
    </div>
</div> 