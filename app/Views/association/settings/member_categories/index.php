<div class="max-w-6xl mx-auto bg-white rounded shadow p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Member Categories</h2>

        <a href="<?= BASE_URL ?>/association/settings/member-categories/create"
           class="px-4 py-2 bg-blue-600 text-white rounded">
            + Add Category
        </a>
    </div>

    <?php if (empty($categories)): ?>
        <p class="text-gray-600">No member categories found.</p>
    <?php else: ?>
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-3 py-2 text-left">Name</th>
                    <th class="border px-3 py-2 text-left">Validity</th>
                    <th class="border px-3 py-2 text-left">Periodicity</th>
                    <th class="border px-3 py-2 text-left">Amount (₹)</th>
                    <th class="border px-3 py-2 text-left">Status</th>
                    <th class="border px-3 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td class="border px-3 py-2"><?= htmlspecialchars($cat->name) ?></td>
                        <td class="border px-3 py-2"><?= ucfirst($cat->validity_type) ?></td>
                        <td class="border px-3 py-2"><?= ucfirst($cat->payment_periodicity) ?></td>
                        <td class="border px-3 py-2"><?= number_format($cat->amount, 2) ?></td>
                        <td>
    <?php if ($cat->is_active == 1): ?>
    <span class="text-green-600 font-semibold">Active</span>
<?php else: ?>
    <span class="text-red-600 font-semibold">Inactive</span>
<?php endif; ?>
</td>
                        <td class="border px-3 py-2">
   <?php if ($cat->is_active == 1): ?>
    <a href="<?= BASE_URL ?>/association/settings/member-categories/deactivate?id=<?= $cat->id ?>"
       class="text-red-600">
        Deactivate
    </a>
<?php else: ?>
    <a href="<?= BASE_URL ?>/association/settings/member-categories/activate?id=<?= $cat->id ?>"
       class="text-green-600">
        Activate
    </a>
<?php endif; ?>
</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>
<script>
document.querySelectorAll('.toggle-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault(); 

        const id = this.dataset.id;

        if (!id) {
            alert('ID missing in button');
            return;
        }

        fetch('<?= BASE_URL ?>/association/settings/member-categories/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(data => {
            console.log(data); // debug

            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Toggle failed');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Network error');
        });
    });
});
</script>