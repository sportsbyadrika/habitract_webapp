<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP | Association SAAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            font-size: 18px;
            letter-spacing: 4px;
            text-align: center;
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

        .info {
            background: #e7f5ff;
            color: #1c7ed6;
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

    <h1>Verify OTP</h1>
    <p>Enter the 6-digit code sent to your email</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="message error">
            Invalid OTP. Please try again.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['expired'])): ?>
        <div class="message error">
            OTP expired. Please request a new one.
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['forgot_email'])): ?>
        <div class="message info">
            OTP sent to <strong><?= htmlspecialchars($_SESSION['forgot_email']) ?></strong>
        </div>
    <?php endif; ?>
     <?php if (isset($_SESSION['dev_otp'])): ?>
        <p class="text-xs text-gray-400 mt-2">
            DEV OTP: <?= htmlspecialchars($_SESSION['dev_otp']) ?>
        </p>
    <?php endif; ?>

    <form method="post" action="/habitract_webapp/public/index.php/forgot-verify-otp">
        <div class="form-group">
            <label>Enter OTP</label>
            <input
                type="text"
                name="otp"
                maxlength="6"
                placeholder=""
                required
            >
        </div>

        <button type="submit" class="btn">
            Verify OTP
        </button>
    </form>

    <div class="footer-links">
        <a href="/habitract_webapp/public/index.php/forgot-password">
            Didn’t receive OTP? Resend
        </a>
    </div>

    <div class="brand">
        © <?= date('Y') ?> Association SAAS
    </div>

</div>

</body>
</html>
