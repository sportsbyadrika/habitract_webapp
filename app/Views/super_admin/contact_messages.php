<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Messages</title>

    <style>
        body {
            font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #1f2937;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
        }

        /* Card */
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        /* Flash message */
        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: 600;
            width: fit-content;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #f9fafb;
            text-align: left;
            padding: 14px;
            font-size: 14px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
            vertical-align: top;
        }

        tr:hover {
            background: #f9fafb;
        }

        /* Email link */
        .email {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .email:hover {
            text-decoration: underline;
        }

        /* Status badge */
        .status {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status.read {
            background: #e0f2fe;
            color: #0369a1;
        }

        .status.new {
            background: #fef3c7;
            color: #92400e;
        }

        /* Button */
        .btn {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-reply {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
        }

        .btn-reply:hover {
            opacity: 0.9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                display: none;
            }

            td {
                border: none;
                padding: 10px 0;
            }

            tr {
                border-bottom: 1px solid #e5e7eb;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <style>
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 10px;
    background: #eef2ff;
    color: #1e40af;
    font-weight: 600;
    text-decoration: none;
    font-size: 14px;
    transition: background 0.2s;
}

.btn-back:hover {
    background: #e0e7ff;
}
</style>
<a href="<?= BASE_URL ?>/super-admin/dashboard" class="btn-back">
    ← Back to Dashboard
</a>
<h1>📩 Contact Messages</h1>

<div class="card">

    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert-success">
            <?= $_SESSION['flash_success']; ?>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($msg['name']) ?></strong></td>

                    <td>
                        <a class="email" href="mailto:<?= htmlspecialchars($msg['email']) ?>">
                            <?= htmlspecialchars($msg['email']) ?>
                        </a>
                    </td>

                    <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>

                    <td><?= date('d M Y, h:i A', strtotime($msg['created_at'])) ?></td>

                    <td>
                        <span class="status <?= $msg['status'] === 'new' ? 'new' : 'read' ?>">
                            <?= ucfirst($msg['status']) ?>
                        </span>
                    </td>

                    <td>
                        <a class="btn btn-reply"
                           href="<?= BASE_URL ?>/super-admin/reply-message?id=<?= $msg['id'] ?>">
                            Reply
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No messages found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>