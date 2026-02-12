<?php require_once __DIR__ . '/../../../layouts/header.php'; ?>

<div class="max-w-4xl mx-auto mt-10 px-4">
    
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Create Fee Head</h1>
        <a href="/habitract_webapp/public/association/settings/fee-heads"
           class="text-sm text-blue-600 hover:underline">
            ← Back to Fee Heads
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">

        <form method="POST" action="/habitract_webapp/public/association/settings/fee-heads/store">

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Fee Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Fee Name
                    </label>
                    <input type="text" name="name"
                      placeholder="e.g. Maintenance Fee"  required
                      class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"/>
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Amount (₹)
                    </label>
                    <input
                       type="number" name="amount" placeholder="e.g. 500"  required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"/>
                </div>

                <!-- Periodicity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Periodicity
                    </label>
                    <select
                        name="periodicity" placeholder="select" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm 
                         focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                          <option value="">Select Periodicity</option>
                         <option value="monthly">Monthly</option>
                         <option value="quarterly">Quarterly</option>
                         <option value="yearly">Yearly</option>
                          <option value="one_time">One Time</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Status
                    </label>
                    <select
                        name="status"
    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-white
           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
>
    <option value="1">Active</option>
    <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 mt-8 pt-6 flex justify-end gap-3">

                <a href="/habitract_webapp/public/association/settings/fee-heads"
                   class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-6 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-slate-600 text-white font-medium hover:bg-blue-700">
                    Save Fee Head
                </button>

            </div>

        </form>

    </div>
</div>

<?php require_once __DIR__ . '/../../../layouts/footer.php'; ?>