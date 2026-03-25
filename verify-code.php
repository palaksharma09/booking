<?php
session_start();

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_code'])) {
    header("Location: forgot-password.php");
    exit();
}

if (isset($_SESSION['reset_code_expires']) && time() > $_SESSION['reset_code_expires']) {
    session_unset();
    header("Location: forgot-password.php?expired=1");
    exit();
}

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = trim($_POST['code']);

    if (empty($entered_code)) {
        $error_message = "Please enter the verification code";
    } elseif (!preg_match('/^\d{6}$/', $entered_code)) {
        $error_message = "Please enter a valid 6-digit code";
    } elseif ($entered_code == $_SESSION['reset_code']) {
        $_SESSION['reset_verified'] = true;
        header("Location: reset-password.php");
        exit();
    } else {
        $error_message = "Invalid verification code. Please try again.";
    }
}

if (isset($_GET['resend']) && $_GET['resend'] == 'true') {
    $new_code = rand(100000, 999999);
    $_SESSION['reset_code'] = $new_code;
    $_SESSION['reset_code_expires'] = time() + 600;
    $success_message = "New verification code sent! Your code is: <strong>$new_code</strong><br>(In production, this would be sent to your email)";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code | Fixora</title>
    <link rel="stylesheet" href="CSS/commonfile.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="dashboard.php" class="auth-logo">Fixora</a>
                <h2>Verify Code</h2>
                <p>Enter the 6-digit code sent to <strong><?php echo htmlspecialchars($_SESSION['reset_email']); ?></strong></p>
            </div>

            <?php if (!empty($success_message)): ?>
                <div class="success-message">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="code">Verification Code</label>
                    <input type="text" id="code" name="code"
                           placeholder="Enter 6-digit code"
                           maxlength="6"
                           pattern="\d{6}"
                           autocomplete="off"
                           required>
                    <small style="font-size: 12px; color: var(--text-light); margin-top: 5px; display: block;">
                        Enter the 6-digit code sent to your email
                    </small>
                </div>

                <button type="submit" class="auth-btn">Verify Code</button>

                <div class="auth-footer">
                    <p>Didn't receive the code? <a href="?resend=true" style="color: var(--secondary-color);">Resend Code</a></p>
                    <p style="margin-top: 15px;"><a href="forgot-password.php" style="color: var(--text-light);">&larr; Back to Forgot Password</a></p>
                </div>
            </form>

            <div class="auth-divider">
                <span>Check your inbox</span>
            </div>
            <div style="text-align: center; font-size: 13px; color: var(--text-light);">
                <p>Code expires in 10 minutes</p>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('code').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });
    </script>
</body>
</html>
