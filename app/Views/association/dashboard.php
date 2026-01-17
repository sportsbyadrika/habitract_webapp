
<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-xl font-bold mb-6 text-gray-800">
        Association Admin Dashboard
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-4xl mx-auto">
        <?php
        $title = 'Total Members';
        $value = $totalMembers ?? 0;
        $color = 'blue';
        $icon  = '👥';
        require __DIR__ . '/../components/dashboard_card.php';
        ?>

        <?php
        $title = 'Pending Dues';
        $value = '₹ ' . number_format($pendingDues ?? 0, 2);
        $color = 'red';
        $icon  = '💰';
       require __DIR__ . '/../components/dashboard_card.php';
        ?>

    </div>
</div>