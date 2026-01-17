<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Create Monthly Bill</h2>

    <form method="POST"
          action="/habitract_webapp/public/index.php/association/monthly-bills/store"
          class="space-y-4">

        <div>
            <label class="block text-sm font-medium">Bill Date</label>
            <input type="date" name="demand_date" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Fee Category</label>
            <input type="text" name="head_of_account" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Amount</label>
            <input type="number" step="0.01" name="amount" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Due Date</label>
            <input type="date" name="due_date" class="w-full border p-2 rounded" required>
        </div>

        <div class="flex justify-end gap-3">
            <a href="/habitract_webapp/public/index.php/association/monthly-bills"
               class="px-4 py-2 border rounded">Cancel</a>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Bill
            </button>
        </div>
    </form>
</div>