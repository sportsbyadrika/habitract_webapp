<nav class="bg-gradient-to-br from-slate-600 via-blue-500 to-slate-600 text-white px-6 py-3 flex justify-between items-center">

    <!-- LEFT -->
    <div class="flex items-center space-x-4">
        <span class="font-bold text-lg">Association SAAS</span>

        <?php if (!empty($associationName)): ?>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                <?= htmlspecialchars($associationName) ?>
            </span>
        <?php endif; ?>
    </div>

    <!-- CENTER MENU -->
    <div class="flex items-center space-x-6">

        <a href="<?= BASE_URL ?>/association/dashboard" class="hover:underline">
            Dashboard
        </a>

        <a href="<?= BASE_URL ?>/association/admins" class="hover:underline">
            Admins
        </a>

        <a href="<?= BASE_URL ?>/association/members" class="hover:underline">
            Members
        </a>

        <!-- SETTINGS DROPDOWN -->
        <div class="relative">
            <button
                onclick="toggleSettingsMenu()"
                class="hover:underline focus:outline-none"
                type="button">
                Settings ▾
            </button>

            <div
                id="settingsMenu"
                class="absolute hidden bg-white text-black mt-2 rounded shadow-lg min-w-[200px] z-50">

                <a href="<?= BASE_URL ?>/association/settings/member-categories"
                   class="block px-4 py-2 hover:bg-gray-100">
                    Member Categories
                </a>

                <a href="<?= BASE_URL ?>/association/settings/fee-heads"
                   class="block px-4 py-2 hover:bg-gray-100">
                    Fee Heads
                </a>
                 <a href="<?= BASE_URL ?>/association/settings/category-fee-mapping"
                   class="block px-4 py-2 hover:bg-gray-100">
                    Category Fee Mapping
                <a href="<?= BASE_URL ?>/association/bills/generate" class="block px-4 py-2 hover:bg-gray-100">
    Generate Bills
</a>

<a href="<?= BASE_URL ?>/association/bills"class="block px-4 py-2 hover:bg-gray-100">
    Bills List
</a>
            </div>
        </div>

        <a href="<?= BASE_URL ?>/association/monthly-bills" class="hover:underline">
              </a>
    </div>

    <!-- RIGHT -->
    <div>
        <a href="<?= BASE_URL ?>/logout"
   class=" bg-gradient-to-r from-blue-600 to-slate-600 px-3 py-1 rounded">
   Logout
</a>
    </div>
</nav>

<!-- DROPDOWN SCRIPT -->
<script>
function toggleSettingsMenu() {
    const menu = document.getElementById('settingsMenu');
    menu.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function (event) {
    const menu = document.getElementById('settingsMenu');
    if (!event.target.closest('.relative')) {
        menu.classList.add('hidden');
    }
});
</script>