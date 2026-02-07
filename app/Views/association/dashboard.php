<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-xl font-bold mb-6 text-gray-800">
        Association Admin Dashboard
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-4xl mx-auto">

        <?php
        // -------- Total Members Card --------
        $title = 'Total Members';
        $value = $totalMembers ?? 0;
        $color = 'blue';
        $icon  = '👥'; // MUST be string
        require __DIR__ . '/../components/dashboard_card.php';
        ?>

        <?php
        // -------- Pending Dues Card --------
        $title = 'Pending Dues';
        $value = '₹ ' . number_format($pendingDues ?? 0, 2);
        $color = 'red';
        $icon  = '💰'; // MUST be string
        require __DIR__ . '/../components/dashboard_card.php';
        ?>

    </div>

</div>