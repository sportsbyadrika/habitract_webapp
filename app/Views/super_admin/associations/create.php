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

        <!-- District Dropdown -->
        <div>
            <label class="block font-medium">District</label>
            <select
                name="district_id"
                required
                class="w-full border rounded px-3 py-2"
            >
                <option value="">-- Select District --</option>

                <?php foreach ($districts as $d): ?>
                    <option value="<?= $d['id'] ?>">
                        <?= htmlspecialchars($d['name']) ?>
                    </option>
                <?php endforeach; ?>
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

</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>