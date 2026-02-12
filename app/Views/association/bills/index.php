<?php
/** @var array $bills */
?>

<style>
body {
    background-color: #f4f6f9;
}

/* Page header */
.page-header h2 {
    font-weight: 600;
    margin-bottom: 6px;
}

.page-header p {
    color: #6b7280;
    font-size: 0.95rem;
}

/* Card container */
.bills-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 12px 32px rgba(0,0,0,0.05);
    padding: 28px;
}

/* Table spacing */
.bills-table {
    border-collapse: separate;
    border-spacing: 0 18px;
}

/* Header */
.bills-table thead th {
    font-size: 0.72rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #6b7280;
    border: none;
    padding: 12px 18px;
    vertical-align: middle;
}

/* Rows */
.bills-table tbody tr {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.04);
}

/* Cells */
.bills-table tbody td {
    padding: 18px 20px;
    border: none;
    vertical-align: middle;
    font-size: 0.95rem;
}

/* Alignment helpers */
.text-start { text-align: left; }
.text-end { text-align: right; white-space: nowrap; }
.text-center { text-align: center; }

/* Pills */
.category-pill {
    background: #eef2ff;
    color: #3730a3;
    padding: 10px 16px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-pill {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    display: inline-block;
    text-transform: capitalize;
}

.status-generated {
    background: #8b96b9;
    color: #3f3b7e;
}

.status-paid {
    background: #dcfce7;
    color: #166534;
}

.status-partial {
    background: #fef3c7;
    color: #92400e;
}

/* Amounts */
.amount-danger {
    color: #dc2626;
    font-weight: 700;
}

/* Action button */
.bills-table .btn {
    padding: 6px 16px;
    border-radius: 999px;
}

/* Hover polish */
.bills-table tbody tr:hover {
    transform: translateY(-2px);
    transition: 0.2s ease;
}
</style>

<div class="container-fluid px-4 mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 page-header">
        
            <h2>Monthly bills generated for members</h2>
               

        <a href="<?= BASE_URL ?>/association/bills/generate"
            class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-slate-600 text-white font-medium hover:bg-blue-700">
            + Generate Bills
        </a>
    </div>

    <!-- Bills Table -->
    <div class="bills-card">
        <table class="table bills-table">
            <thead>
                <tr>
                    <th class="text-start">#</th>
                    <th class="text-start">Member</th>
                    <th class="text-start">Category</th>
                    <th class="text-start">Billing Month</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Outstanding</th>
                    <th class="text-center">Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php if (empty($bills)): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        No bills generated yet
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($bills as $bill): ?>
                    <tr>
                        <td class="text-start"><?= $bill->id ?></td>

                        <td class="text-start">
                            <strong><?= htmlspecialchars($bill->member_name) ?></strong>
                        </td>

                        <td class="text-middle">
                            <span class="category-pill">
                                <?= htmlspecialchars($bill->category_name) ?>
                            </span>
                        </td>

                        <td class="text-start">
                            <?= date('M Y', strtotime($bill->bill_year . '-' . $bill->bill_month . '-01')) ?>
                        </td>

                        <td class="text-end">
                            ₹<?= number_format($bill->total_amount, 2) ?>
                        </td>

                        <td class="text-end amount-danger">
                            ₹<?= number_format($bill->outstanding_amount, 2) ?>
                        </td>
<td>
    <?php
        $status = (!empty($bill->status)) ? $bill->status : 'generated';
    ?>
    <span class="status-pill status-<?= $status ?>">
        <?= ucfirst($status) ?>
    </span>
</td>
<td class="text-end">
    <a href="<?= BASE_URL ?>/association/bills/show?id=<?= $bill->id ?>">
        View
    </a>

    &nbsp;|&nbsp;

    <a href="javascript:void(0);"
       onclick="sendBillWhatsApp(<?= $bill->id ?>)">
        📲 Send WhatsApp
    </a>
</td>
                        
                        

  
                
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        
       

    </div>
</div>
<script>
function sendBillWhatsApp(billId) {
    if (!confirm("Send WhatsApp bill notification?")) return;

    fetch('/habitract_webapp/public/association/bills/send-whatsapp', {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ bill_id: billId })
    })
    .then(res => res.text())
    .then(text => {
        try {
            const data = JSON.parse(text);
            alert(data.message ?? "WhatsApp sent");
            console.log(data);
        } catch (e) {
            console.error(text);
            alert("Server error");
        }
    })
    .catch(err => {
        console.error(err);
        alert("WhatsApp failed");
    });
}
</script>