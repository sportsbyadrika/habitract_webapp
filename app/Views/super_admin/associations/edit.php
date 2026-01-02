<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/navbar.php'; ?>
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-6">Edit Association</h2>

    <form method="post" action="/habitract_webapp/public/index.php/super-admin/associations/update">

        <input type="hidden" name="id" value="<?= $association['id'] ?>">

        <!-- Association Name -->
        <div class="mb-4">
            <label class="block mb-1">Association Name</label>
            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($association['name']) ?>"
                class="w-full border px-3 py-2 rounded"
                required
            >
        </div>
        <!-- State -->
        <div class="mb-4">
            <label class="block mb-1">State</label>
            <select name="state_id" id="state_id" class="w-full border rounded px-3 py-2">
              <option value="">-- Select State --</option>
              <?php foreach ($states as $state): ?>
               <option value="<?= $state['id'] ?>"
                  <?= ($state['id'] == $stateId) ? 'selected' : '' ?>>
               <?= htmlspecialchars($state['name']) ?>
             </option>
             <?php endforeach; ?>
           </select>
        </div>


        <!-- District -->
        <div class="mb-4">
            <label class="block mb-1">District</label>
           <select name="district_id" id="district_id" class="w-full border rounded px-3 py-2">
             <option value="">-- Select District --</option>
             <?php foreach ($districts as $d): ?>
             <option value="<?= $d['id'] ?>"
             <?= ($d['id'] == $districtId) ? 'selected' : '' ?>>
             <?= htmlspecialchars($d['name']) ?>
             </option>
             <?php endforeach; ?>
           </select>
        </div>

        <!-- Location -->
        <div class="mb-4">
            <label class="block mb-1">Location</label>
            <input
                type="text"
                name="location"
                value="<?= htmlspecialchars($association['location']) ?>"
                class="w-full border px-3 py-2 rounded"
            >
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>
            <a href="/habitract_webapp/public/index.php/super-admin/associations"
               class="bg-gray-300 px-4 py-2 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>