<!DOCTYPE html>

<nav class="bg-blue-600 text-white px-6 py-3 flex justify-between items-center">
    <div class="font-bold text-lg">
        Association SAAS
    </div>

    <div class="space-x-4">
        <a href="/habitract_webapp/public/index.php/super-admin/dashboard"
           class="hover:underline">
            Dashboard
        </a>

        <div class="relative inline-block">
    <button id="assocBtn"
        class="hover:underline focus:outline-none">
        Associations ▾
    </button>

    <div id="assocMenu"
         class="absolute right-0 mt-2 w-48 bg-white text-black rounded shadow-md hidden z-50">
        <a href="/habitract_webapp/public/index.php/super-admin/associations/create"
           class="block px-4 py-2 hover:bg-gray-100">
            Add Association
       
        <a href="/habitract_webapp/public/index.php/super-admin/associations"
           class="block px-4 py-2 hover:bg-gray-100">
            View Association
        </a>
    </div>

        <a href="/habitract_webapp/public/index.php/logout"
           class="bg-blue-800 px-3 py-1 rounded">
            Logout
        </a>
    </div>
</nav>

<div class="p-6">
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('assocBtn');
    const menu = document.getElementById('assocMenu');

    if (btn && menu) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', function () {
            menu.classList.add('hidden');
        });
    }
});
</script>