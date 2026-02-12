
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Association SAAS | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-600 via-blue-500 to-slate-700 relative overflow-hidden">

<!-- HERO ILLUSTRATION -->
<div
    class="absolute inset-0 bg-no-repeat bg-right lg:bg-contain bg-[length:80%] lg:bg-[length:45%] opacity-10 pointer-events-none"
    style="background-image: url('/habitract_webapp/public/assets/images/association-hero.svg');">
</div>

<!-- WATERMARK -->
<div
    class="absolute inset-0 bg-no-repeat bg-center opacity-[0.05] pointer-events-none"
    style="background-image: url('/habitract_webapp/public/assets/images/association-watermark.svg');
           background-size: 420px;">
</div>

<!-- ================= BACKGROUND GLOW ================= -->
<div class="absolute -top-40 -left-40 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
<div class="absolute top-1/3 -right-40 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

<!-- ================= DARK MODE BUTTON ================= -->
<div class="fixed top-4 right-4 z-50">
    <button
        onclick="toggleDarkMode()"
        class="px-4 py-2 bg-white/90 backdrop-blur rounded-full shadow-lg text-sm hover:shadow-xl transition">
        🌙 Dark Mode
    </button>
</div>

<!-- ================= PAGE CONTENT ================= -->
<div class="max-w-7xl mx-auto px-6 py-10 relative z-10">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

        <!-- ================= LEFT: PRICING ================= -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-10">

            <h2 class="text-3xl font-bold text-gray-800 mb-8">Pricing Plans</h2>

            <!-- BASIC PLAN -->
            <div class="relative border-2 border-blue-600 rounded-2xl p-5 mb-8 bg-white
                        transition hover:-translate-y-2 hover:shadow-2xl">

                <span class="absolute -top-4 right-6 bg-gradient-to-r from-blue-500 to-slate-600
                             text-white text-xs px-4 py-1 rounded-full shadow-lg">
                    ⭐ Most Popular
                </span>

                <h3 class="text-xl font-semibold text-gray-800">Basic Association Plan</h3>

                <p class="text-4xl font-bold text-blue-500 mt-2">
                    ₹2500 <span class="text-sm text-gray-500">/ year</span>
                </p>

                <ul class="mt-6 text-sm text-gray-700 space-y-3">
                    <li>✔ Members Management</li>
                    <li>✔ Billing & Receipts</li>
                    <li>✔ Notices & Complaints</li>
                    <li>✔ Reports & Analytics</li>
                    <li>✔ Email Notifications</li>
                    <li class="font-semibold">✔ Maximum members: 250</li>
                </ul>

                <p class="mt-5 text-sm text-gray-500">
                    Register to activate this plan
                </p>
            </div>

            <!-- CUSTOM PLAN -->
            <div class="border border-dashed rounded-2xl p-7
                        transition hover:-translate-y-2 hover:shadow-xl bg-white">

                <h3 class="text-xl font-semibold text-gray-800">Custom Plan</h3>

                <p class="text-gray-600 mt-2">
                    Tailored pricing & features for large associations
                </p>

                <a href="/habitract_webapp/public/index.php/contact"
                   class="inline-block mt-5 px-5 py-2.5 border border-blue-600 text-blue-600
                          rounded-xl hover:bg-blue-50 transition">
                    Contact Us
                </a>
            </div>

        </div>

        <!-- ================= CENTER DIVIDER ================= -->
        <div class="hidden lg:flex items-center justify-center">
            <div class="w-40 h-px bg-gradient-to-r from-white/60 to-white/0"></div>
        </div>

        <!-- ================= RIGHT: LOGIN ================= -->
        <div class="flex justify-end">
            <div class="sticky top-24 w-full max-w-sm">

                <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-7">

                    <div class="text-center mb-5">
                        <h1 class="text-2xl font-bold text-gray-800">
                            Association SaaS Dashboard
                        </h1>
                        <p class="text-gray-500 text-sm">
                            Sign in to manage your association
                        </p>
                    </div>

                    <form 
                    
                          id="loginForm"
                          method="post"
                          action="/habitract_webapp/public/index.php/login"
                          class="space-y-4">
                          <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
  <p class="text-red-600 text-sm mb-3">
    Invalid username or password
  </p>
<?php endif; ?>

                        <input
                            type="text"
                            id="identity"
                            name="identity"
                            placeholder="Username / Email"
                            required
                            class="w-full px-4 py-2.5 border rounded-xl focus:ring-2
                                   focus:ring-blue-500 outline-none">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Password"
                            required
                            class="w-full px-4 py-2.5 border rounded-xl focus:ring-2
                                   focus:ring-blue-500 outline-none">
                        <p id="errorMsg" class="text-red-600 text-sm hidden">Invalid username or password</p>
                        <button
                            type="submit"
                            class="w-full py-2.5 bg-gradient-to-r from-blue-600 to-slate-600
                                   text-white rounded-xl font-semibold hover:opacity-90 transition">
                            Login
                        </button>
                    </form>

                    <div class="text-center mt-4 text-sm">New here?
                        <a href="/habitract_webapp/public/index.php/register"
                           class="text-blue-600 hover:underline">
                            Register your Association
                        </a>
                        <br>
                        <a href="/habitract_webapp/public/index.php/forgot-password"
                           class="text-gray-500 hover:underline">
                            Forgot password?
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<script src="/habittract_webapp/public/js/login.js"></script>
<!-- ================= DARK MODE SCRIPT ================= -->
<script>
function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
}
</script>

</body>
</html>
