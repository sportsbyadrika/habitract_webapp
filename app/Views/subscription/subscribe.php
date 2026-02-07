<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscribe | Association SAAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/habitract_webapp/public/assets/css/subscribe.css">
</head>
<body>

<div class="subscription-wrapper">
    <div class="subscription-card">

        <div class="badge">Premium Access</div>

        <h1>Subscription Required</h1>
        <p class="subtitle">
            Unlock all features and manage your association seamlessly
        </p>

       <div class="plan-box">
    <h2>Basic Plan</h2>

    <div class="price">
        <span class="currency">₹</span>2500
        <span class="duration">/ year</span>
    </div>
</div>

<ul class="features">
    <li>Members Management</li>
    <li>Billing & Receipts</li>
    <li>Notices & Complaints</li>
    <li>Reports & Analytics</li>
    <li>Email Notifications</li>
    <li><strong>Maximum members allowed: 250</strong></li>
</ul>

        <form method="post" action="/habitract_webapp/public/index.php/subscribe">
            <button type="submit" class="btn-primary">
                Subscribe Now
            </button>
        </form>

        <div class="actions">
            <a href="/habitract_webapp/public/index.php/logout">Logout</a>
        </div>
<?php if (isset($_GET['success'])): ?>
<div id="successModal" class="success-modal-overlay">
    <div class="success-modal">
        <div class="success-icon">✓</div>
        <h3>Subscription Activated</h3>
        <p>Your subscription has been activated successfully.</p>
    </div>
</div>

<script>
    setTimeout(() => {
        window.location.href = "/habitract_webapp/public/index.php/association/dashboard";
    }, 2500); // 2.5 seconds
</script>
<?php endif; ?>
        <footer>
            © 2026 Association SAAS
        </footer>

    </div>
</div>

</body>
</html>
