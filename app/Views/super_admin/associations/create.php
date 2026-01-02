<?php require_once __DIR__ . '/../../layouts/navbar.php'; ?>

<div class="p-6 max-w-3xl mx-auto bg-white shadow rounded">

    <h2 class="text-xl font-bold mb-4">Add Association</h2>

    <form method="post" action="/habitract_webapp/public/index.php/super-admin/associations/store" class="space-y-4">

        <!-- Association Name -->
        <div>
            <label class="block font-medium">Association Name</label>
            <input
                type="text"
                name="name"
                required
                class="w-full border rounded px-3 py-2"
            >
        </div>

        <!-- Association Code -->
        <div>
            <label class="block font-medium">Association Code</label>
            <input
                type="text"
                name="association_code"
                required
                class="w-full border rounded px-3 py-2"
            >
        </div>
 <div>
    <label class="block text-sm font-medium mb-1">State</label>
    <select id="state_id" name="state_id" class="w-full border rounded px-3 py-2" required>
        <option value="">-- Select State --</option>
        <?php foreach ($states as $state): ?>
            <option value="<?= $state['id'] ?>">
                <?= htmlspecialchars($state['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
        <!-- District Dropdown -->
        <div>
            <label class="block font-medium">District</label>
            <select id="district_id" name="district_id" class="w-full border rounded px-3 py-2" required>
    <option value="">-- Select District --</option>
</select>
        </div>
       


        <!-- Location -->
        <div>
            <label class="block font-medium">Location</label>
            <input
                type="text"
                name="location"
                class="w-full border rounded px-3 py-2"
            >
        </div>

        <!-- Service Dates -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium">Service Start Date</label>
                <input
                    type="date"
                    name="service_start_date"
                    class="w-full border rounded px-3 py-2"
                >
            </div>

            <div>
                <label class="block font-medium">Service End Date</label>
                <input
                    type="date"
                    name="service_end_date"
                    class="w-full border rounded px-3 py-2"
                >
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded"
            >
                Save
            </button>

            <a
                href="/habitract_webapp/public/index.php/super-admin/associations"
                class="bg-gray-300 px-4 py-2 rounded"
            >
                Cancel
            </a>
        </div>

    </form>
<script>
document.getElementById('state_id').addEventListener('change', function () {
    const stateId = this.value;
    const districtSelect = document.getElementById('district_id');

    //districtSelect.innerHTML = '<option value="">-- Select District --</option>';

   // if (!stateId) return;
districtSelect.innerHTML = '<option value="">Loading...</option>';

    if (!stateId) {
        districtSelect.innerHTML = '<option value="">-- Select District --</option>';
        return;
    }
    fetch('/habitract_webapp/public/index.php/super-admin/districts/by-state?state_id=' + stateId)
        .then(res => res.json())
        .then(data => {
            data.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.id;
                opt.textContent = d.name;
                districtSelect.appendChild(opt);
            });
        })
        .catch(err => console.error(err));
});
</script>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>