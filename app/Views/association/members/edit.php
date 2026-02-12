<div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">

   <h2 class="text-xl font-semibold mb-4">Edit Member</h2>

<form method="POST"
      action="/habitract_webapp/public/index.php/association/members/update">
    <input type="hidden" name="id" value="<?= $member['id'] ?>">
        <!-- House Number -->
       <div class="mb-4">
            <label class="block text-sm font-medium">House Number</label>
           <input type="text" name="house_number" value="<?= htmlspecialchars($member['house_number']) ?>" readonly>
        </div>

        <!-- Owner Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium">Owner Name</label>
            <input type="text"name="owner_name" value="<?= htmlspecialchars($member['owner_name']) ?>"  class="w-full border px-3 py-2 rounded" required>
</div>
        <!-- Mobile -->
        <div class="mb-4">
            <label class="block text-sm font-medium">Mobile Number</label>
            <input type="text"name="mobile_number"value="<?= htmlspecialchars($member['mobile_number']) ?>"  class="w-full border px-3 py-2 rounded" required>
        </div>

       
        <!-- Number of Occupants -->
        <div class="mb-4">
            <label class="block text-sm font-medium">Number of Members</label>
            <input type="number"name="occupants"value="<?= (int)$member['occupants'] ?>" class="w-full border px-3 py-2 rounded" min="1">
        </div>

        
        <!-- Status -->
       <div class="mb-4">
            <label class="block text-sm font-medium">Status</label>
            <select name="status"  class="w-full border px-3 py-2 rounded"><option value="Active" <?= $member['status'] === 'Active' ? 'selected' : '' ?>>
                 Active
               </option>
                  <option value="Inactive" <?= $member['status'] === 'Inactive' ? 'selected' : '' ?>>
                  Inactive
               </option>
            </select>

        </div>

         <!-- Buttons -->
        <div class="md:col-span-2 flex justify-end gap-2">
            <a href="/habitract_webapp/public/index.php/association/members"
               class="px-4 py-2 border rounded">Cancel</a>

            <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-slate-600  text-white px-6 py-2 rounded hover:bg-blue-700">
                Save Member
            </button>
        </div>

    </form>
</div>