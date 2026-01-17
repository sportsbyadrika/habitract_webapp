<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Association SAAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/habitract_webapp/public/assets/css/auth.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #3b5bff, #6f42c1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-container {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            text-align: center;
        }

        .auth-container h1 {
            margin: 0 0 8px;
            font-size: 24px;
            color: #222;
        }

        .auth-container p {
            margin: 0 0 24px;
            color: #666;
            font-size: 14px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            color: #444;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #5c7cfa;
            box-shadow: 0 0 0 3px rgba(92,124,250,0.15);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #3b5bff;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn:hover {
            background: #364fc7;
        }

        .message {
            margin-bottom: 16px;
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 13px;
        }

        .error {
            background: #ffe3e3;
            color: #c92a2a;
        }

        .success {
            background: #d3f9d8;
            color: #2b8a3e;
        }

        .footer-links {
            margin-top: 20px;
            font-size: 13px;
        }

        .footer-links a {
            color: #3b5bff;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .brand {
            margin-top: 24px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>

<div class="auth-container">

    <h1>Forgot Password</h1>
    <p>Enter your registered admin email to receive an OTP</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="message error">
            <?php
                if ($_GET['error'] === 'notfound') {
                    echo 'Email not found or account inactive';
                } elseif ($_GET['error'] === 'expired') {
                    echo 'OTP expired. Please try again';
                } else {
                    echo 'Please enter a valid email';
                }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="message success">
            OTP sent successfully to your email
        </div>
    <?php endif; ?>

    <form method="post" action="/habitract_webapp/public/index.php/forgot-password">
        <div class="form-group">
            <label>Admin Email</label>
            <input
                type="email"
                name="email"
                placeholder="admin@example.com"
                required
            >
        </div>

        <button type="submit" class="btn">
            Send OTP
        </button>
    </form>

    <div class="footer-links">
        <a href="/habitract_webapp/public/index.php/login">← Back to Login</a>
    </div>

    <div class="brand">
        © <?= date('Y') ?> Association SAAS
    </div>

</div>

</body>
</html>