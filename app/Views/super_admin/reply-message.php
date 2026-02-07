<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reply to Contact Message</title>

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

        .card {
            background: #ffffff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            max-width: 900px;
        }

        .info {
            display: grid;
            grid-template-columns: 120px 1fr;
            row-gap: 12px;
            column-gap: 16px;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .info strong {
            color: #6b7280;
        }

        .message-box {
            background: #f9fafb;
            border-left: 4px solid #2563eb;
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            line-height: 1.6;
        }

        textarea {
            width: 100%;
            min-height: 140px;
            padding: 14px;
            font-size: 14px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            resize: vertical;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-send {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
        }

        .btn-send:hover {
            opacity: 0.95;
        }

        .btn-cancel {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-cancel:hover {
            background: #d1d5db;
        }

        /* Success dialog */
        #successDialog {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dcfce7;
            color: #166534;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
            z-index: 9999;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .info {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<h1>✉️ Reply to Contact Message</h1>

<div class="card">

    <?php if (!empty($replySent)): ?>
        <div id="successDialog">
            ✅ Reply sent successfully
        </div>

        <script>
            setTimeout(() => {
                window.location.href = "<?= BASE_URL ?>/super-admin/contact-messages";
            }, 2500);
        </script>
    <?php endif; ?>

    <div class="info">
        <strong>Name</strong>
        <div><?= htmlspecialchars($message['name']) ?></div>

        <strong>Email</strong>
        <div><?= htmlspecialchars($message['email']) ?></div>
    </div>

    <div class="message-box">
        <?= nl2br(htmlspecialchars($message['message'])) ?>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/super-admin/send-reply">
        <input type="hidden" name="id" value="<?= $message['id'] ?>">

        <textarea name="reply" placeholder="Type your reply here..." required></textarea>

        <div class="actions">
            <button type="submit" class="btn btn-send">Send Reply</button>

            <a href="<?= BASE_URL ?>/super-admin/contact-messages" class="btn btn-cancel">
                Cancel
            </a>
        </div>
    </form>

</div>

</body>
</html>
