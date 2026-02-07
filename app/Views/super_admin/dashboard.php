

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
    <?php if ($newMessages > 0): ?>
    <p style="margin-top:10px;">
        <a href="<?= BASE_URL ?>/super-admin/contact-messages"
           style="color:#e63946;font-weight:bold;text-decoration:none;">
            📩 New Messages: <?= $newMessages ?>
        </a>
    </p>
<?php else: ?>
    <p style="margin-top:10px;color:gray;">
        📩 No new messages
    </p>
<?php endif; ?>
</div> 