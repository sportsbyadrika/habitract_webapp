<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../../layouts/header.php';
require __DIR__ . '/../../layouts/navbar_association_admin.php';
?>

<style>
body {
  background:#f1f5f9;
  font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
}

.invoice {
  max-width: 900px;
  margin: 50px auto;
  background:#fff;
  border-radius:10px;
  box-shadow:0 12px 30px rgba(0,0,0,.08);
  padding:40px;
}

/* Header */
.invoice-header {
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  border-bottom:2px solid #e5e7eb;
  padding-bottom:20px;
}

.invoice-title {
  font-size:26px;
  font-weight:700;
  color:#1d4ed8;
}

.invoice-sub {
  font-size:14px;
  color:#6b7280;
}

.invoice-meta {
  text-align:right;
  font-size:14px;
}

.invoice-meta div {
  margin-bottom:6px;
}

/* Info blocks */
.info-grid {
  display:grid;
  grid-template-columns: repeat(3, 1fr);
  gap:30px;
  margin:30px 0;
}

.label {
  font-size:12px;
  color:#6b7280;
  margin-bottom:4px;
}

.value {
  font-size:15px;
  font-weight:600;
  color:#111827;
}

/* Status badge */
.status {
  display:inline-block;
  padding:6px 14px;
  font-size:12px;
  font-weight:600;
  border-radius:999px;
  background:#fef3c7;
  color:#92400e;
}

/* Table */
table {
  width:100%;
  border-collapse:collapse;
  margin-top:10px;
}

th {
  background:#f9fafb;
  text-align:left;
  font-size:13px;
  color:#374151;
  padding:12px;
  border-bottom:1px solid #e5e7eb;
}

td {
  padding:14px 12px;
  font-size:14px;
  border-bottom:1px solid #e5e7eb;
}

.amount {
  text-align:right;
}

/* Totals */
.totals {
  width:350px;
  margin-left:auto;
  margin-top:20px;
}

.totals-row {
  display:flex;
  justify-content:space-between;
  padding:10px 0;
  font-size:14px;
}

.totals-row.final {
  border-top:2px solid #e5e7eb;
  margin-top:10px;
  padding-top:14px;
  font-size:18px;
  font-weight:700;
}

/* Footer */
.invoice-footer {
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-top:40px;
}

.back {
  color:#2563eb;
  text-decoration:none;
  font-size:14px;
}

.print {
  background:#2563eb;
  color:#fff;
  padding:10px 22px;
  border-radius:6px;
  text-decoration:none;
  font-size:14px;
}

@media print {
  body { background:#fff; }
  .print, .back { display:none; }
}
</style>

<div class="invoice">

  <!-- HEADER -->
  <div class="invoice-header">
    <div>
      <div class="invoice-title">Monthly Maintenance Bill</div>
      <div class="invoice-sub">Association Invoice</div>
    </div>

    <div class="invoice-meta">
      <div><strong>Bill Month:</strong> <?= $bill['bill_month'] ?>/<?= $bill['bill_year'] ?></div>
      <div><strong>Due Date:</strong> <?= date('d-m-Y', strtotime($bill['due_date'])) ?></div>
    </div>
  </div>

  <!-- INFO -->
  <div class="info-grid">
    <div>
      <div class="label">Member Name</div>
      <div class="value"><?= $bill['member_name'] ?? '-' ?></div>
    </div>

    <div>
      <div class="label">House Number</div>
      <div class="value"><?= $bill['house_number'] ?? '-' ?></div>
    </div>

    <div>
      <div class="label">Status</div>
      <span class="status"><?= ucfirst($bill['status']) ?></span>
    </div>
  </div>

  <!-- FEES -->
  <h3 style="margin-bottom:10px;">Fee Details</h3>

  <table>
    <thead>
      <tr>
        <th>Fee Head</th>
        <th class="amount">Amount (₹)</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <td><?= $item['fee_head_name'] ?></td>
          <td class="amount">₹<?= number_format($item['amount'],2) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- TOTALS -->
  <div class="totals">
    <div class="totals-row">
      <span>Total</span>
      <span>₹<?= number_format($bill['total_amount'],2) ?></span>
    </div>

    <div class="totals-row">
      <span>Paid</span>
      <span>₹<?= number_format($bill['paid_amount'],2) ?></span>
    </div>

    <div class="totals-row final">
      <span>Outstanding</span>
      <span>₹<?= number_format($bill['outstanding_amount'],2) ?></span>
    </div>
  </div>

  <!-- FOOTER -->
  <div class="invoice-footer">
    <a class="back" href="<?= BASE_URL ?>/association/bills">← Back to Monthly Bills</a>
    <a class="print" href="#" onclick="window.print()">Print Invoice</a>
  </div>

</div>