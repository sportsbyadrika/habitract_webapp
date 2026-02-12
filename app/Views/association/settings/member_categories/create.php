<div class="max-w-3xl mx-auto bg-white rounded shadow p-6">

    <h2 class="text-xl font-semibold mb-6">Create Member Category</h2>

    <form method="POST"
          action="<?= BASE_URL ?>/association/settings/member-categories/store"
          class="space-y-5">

        <!-- Row 1 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Category Name</label>
                <input type="text"
                       name="name"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Validity Type</label>
                <select name="validity_type"
                        class="w-full border rounded px-3 py-2"
                        required>
                    <option value="">Select</option>
                    <option value="lifetime">Lifetime</option>
                    <option value="annual">Annual</option>
                </select>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Payment Periodicity</label>
                <select name="payment_periodicity"
                        class="w-full border rounded px-3 py-2"
                        required>
                    <option value="">Select</option>
                    <option value="one_time">One Time</option>
                    <option value="monthly">Monthly</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Amount (₹)</label>
                <input type="number"
                       name="amount"
                       step="0.01"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description"
                      rows="3"
                      class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3">
            <a href="<?= BASE_URL ?>/association/settings/member-categories"
               class="px-4 py-2 border rounded">
                Cancel
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-gradient-to-r from-blue-600 to-slate-600 text-white rounded">
                Save Category
            </button>
        </div>

    </form>

</div>