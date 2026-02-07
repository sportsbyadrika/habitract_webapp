<?php
/*if (session_status() === PHP_SESSION_NONE) {
    session_start();
}*/

//require __DIR__ . '/../../layouts/header.php';
//require __DIR__ . '/../../layouts/navbar_association_admin.php';
?>

<style>
    body {
        background-color: #f5f7fb;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .page-wrapper {
        max-width: 560px;
        margin: 90px auto;
    }

    .card {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        padding: 32px 36px;
    }

    .card-title {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        color: #2563eb;
        margin-bottom: 28px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        font-size: 14px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background-color: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37,99,235,0.15);
    }

    .btn-primary {
        width: 100%;
        margin-top: 10px;
        padding: 13px;
        font-size: 15px;
        font-weight: 600;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    .btn-primary:hover {
        opacity: 0.95;
    }

    .alert {
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 18px;
        font-size: 14px;
    }

    .alert-success {
        background-color: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background-color: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .hint {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }
</style>

<div class="page-wrapper">
    <div class="card">

        <div class="card-title">Generate Monthly Bills</div>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/association/bills/generate">

            <div class="form-group">
                <label>Member Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat->id ?>">
                            <?= htmlspecialchars($cat->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="hint">Bills will be generated for all members under this category</div>
            </div>

          <div class="form-group">
    <label for="bill_month">Billing Month</label>

    <input
        type="month"
        id="bill_month"
        name="bill_month"
        class="form-control"
        required
    >

    <small class="text-muted">
        Choose the month for which bills should be generated
    </small>
</div>

            <button type="submit" class="btn-primary">
                Generate Bills
            </button>

        </form>

    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>