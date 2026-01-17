<div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">

    <h2 class="text-xl font-semibold mb-6">Add Member</h2>

    <form method="POST" action="/habitract_webapp/public/index.php/association/members/store" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- House Number -->
        <div>
            <label class="block text-sm font-medium">House Number</label>
            <input type="text" name="house_number" required class="w-full border rounded px-3 py-2">
        </div>

        <!-- Owner Name -->
        <div>
            <label class="block text-sm font-medium">Owner Name</label>
            <input type="text" name="owner_name" required class="w-full border rounded px-3 py-2">
        </div>

        <!-- Mobile -->
        <div>
            <label class="block text-sm font-medium">Mobile Number</label>
            <input type="text" name="mobile_number" required class="w-full border rounded px-3 py-2">
        </div>

        <!-- Location -->
        <div>
            <label class="block text-sm font-medium">Location</label>
            <input type="text" name="location" class="w-full border rounded px-3 py-2">
        </div>

        <!-- Number of Occupants -->
        <div>
            <label class="block text-sm font-medium">Number of Members</label>
            <input type="number" name="occupants" min="1" class="w-full border rounded px-3 py-2">
        </div>

        <!-- Date of Join -->
        <div>
            <label class="block text-sm font-medium">Date of Join</label>
            <input type="date" name="date_of_join" class="w-full border rounded px-3 py-2">
        </div>
<!-- Member Category -->
<div>
  <label class="block text-sm font-medium">Member Category</label>
  <select name="member_category_id" class="w-full border rounded px-3 py-2">
    <option value="">Select Category</option>
    <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat->id ?>">
            <?= htmlspecialchars($cat->name) ?>
        </option>
    <?php endforeach; ?>
</select>
</div>
   
        <!-- Status -->
        <div>
            <label class="block text-sm font-medium">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <!-- Remarks -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium">Remarks</label>
            <textarea name="remarks" rows="3" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <!-- Buttons -->
        <div class="md:col-span-2 flex justify-end gap-2">
            <a href="/habitract_webapp/public/index.php/association/members"
               class="px-4 py-2 border rounded">Cancel</a>

            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Save Member
            </button>
        </div>

    </form>
</div>