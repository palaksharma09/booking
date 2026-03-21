<?php
session_start();
include 'db_conn.php';

$email = "";
$success_message = "";
$error_message = "";
$email_sent = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $error_message = "Please enter your email address";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address";
    } else {
        $check_sql = "SELECT user_id, user_name FROM users WHERE user_email_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $verification_code = rand(100000, 999999);

            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_code'] = $verification_code;
            $_SESSION['reset_code_expires'] = time() + 600;
            $_SESSION['reset_user_id'] = $user['user_id'];

            $success_message = "Verification code sent! Your code is: <strong>$verification_code</strong><br>(In production, this would be sent to your email)";
            $email_sent = true;
            header("refresh:3;url=verify-code.php");
        } else {
            $error_message = "No account found with this email address";
        }
        $check_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | ServiceHub</title>
    <link rel="stylesheet" href="CSS/commonfile.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="dashboard.php" class="auth-logo">ServiceHub</a>
                <h2>Forgot Password?</h2>
                <p>Enter your email to receive a verification code</p>
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
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           placeholder="Enter your registered email"
                           value="<?php echo htmlspecialchars($email); ?>"
                           required>
                </div>

                <button type="submit" class="auth-btn">Send Code</button>

                <div class="auth-footer">
                    <p><a href="login.php" style="color: var(--secondary-color);">&larr; Back to Login</a></p>
                </div>
            </form>

            <div class="auth-divider">
                <span>Need help?</span>
            </div>
            <div style="text-align: center; font-size: 14px;">
                <p>Contact support at <strong>support@servicehub.com</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
