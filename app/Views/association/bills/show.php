<?php
$total = 0;
foreach ($items as $item) {
    $total += $item->amount;
}
?>

<style>
.invoice-container {
    max-width: 900px;
    margin: 30px auto;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    padding: 32px;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
}

.invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
}

.invoice-title {
    font-size: 22px;
    font-weight: 700;
}

.badge {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    background: #eef2ff;
    color: #4338ca;
}

.invoice-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-top: 24px;
}

.meta-box {
    background: #f9fafb;
    border-radius: 10px;
    padding: 14px 16px;
}

.meta-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 4px;
}

.meta-value {
    font-size: 15px;
    font-weight: 600;
}

.invoice-table {
    width: 100%;
    margin-top: 30px;
    border-collapse: collapse;
}

.invoice-table th {
    text-align: left;
    font-size: 13px;
    text-transform: uppercase;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 10px;
}

.invoice-table td {
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 15px;
}

.invoice-table td.amount {
    text-align: right;
    font-weight: 600;
}

.summary {
    margin-top: 24px;
    display: flex;
    justify-content: flex-end;
}

.summary-box {
    width: 320px;
    background: #f9fafb;
    border-radius: 12px;
    padding: 18px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 15px;
}

.summary-row.total {
    font-size: 18px;
    font-weight: 700;
}

.summary-row.outstanding {
    color: #dc2626;
    font-weight: 700;
}

.back-link {
    margin-top: 24px;
    display: inline-block;
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
}

.back-link:hover {
    text-decoration: underline;
}
</style>

<div class="invoice-container">

    <!-- Header -->
    <div class="invoice-header">
        <div class="invoice-title">Invoice</div>
        <span class="badge">Generated</span>
    </div>

    <!-- Meta info -->
    <div class="invoice-meta">
        <div class="meta-box">
            <div class="meta-label">Member</div>
            <div class="meta-value"><?= htmlspecialchars($bill->member_name) ?></div>
        </div>

        <div class="meta-box">
            <div class="meta-label">Category</div>
            <div class="meta-value"><?= htmlspecialchars($bill->category_name) ?></div>
        </div>

        <div class="meta-box">
            <div class="meta-label">Billing Month</div>
            <div class="meta-value"><?= date(
    'M Y',
    strtotime($bill->bill_year . '-' . str_pad($bill->bill_month, 2, '0', STR_PAD_LEFT) . '-01')
) ?></div>
        </div>
    </div>

    <!-- Line items -->
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align:right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item->description) ?></td>
                    <td class="amount">₹<?= number_format($item->amount, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <div class="summary-box">
            <div class="summary-row">
                <span>Total</span>
                <span>₹<?= number_format($total, 2) ?></span>
            </div>
            <div class="summary-row outstanding">
                <span>Outstanding</span>
                <span>₹<?= number_format($bill->outstanding_amount, 2) ?></span>
            </div>
        </div>
    </div>

    <a class="back-link" href="<?= BASE_URL ?>/association/bills">← Back to Bills</a>

</div>
