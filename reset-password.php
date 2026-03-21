<?php
session_start();

if (!isset($_SESSION['reset_verified']) || $_SESSION['reset_verified'] !== true) {
    header("Location: forgot-password.php");
    exit();
}

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_user_id'])) {
    header("Location: forgot-password.php");
    exit();
}

include 'db_conn.php';

$password = "";
$confirm_password = "";
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($password)) {
        $error_message = "Please enter a new password";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters";
    } elseif ($password != $confirm_password) {
        $error_message = "Passwords do not match";
    } else {
        $user_id = $_SESSION['reset_user_id'];
        $update_sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $password, $user_id);

        if ($update_stmt->execute()) {
            $success_message = "Password updated successfully! Redirecting to login...";
            unset($_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['reset_code_expires'], $_SESSION['reset_user_id'], $_SESSION['reset_verified']);
            header("refresh:3;url=login.php?reset=success");
        } else {
            $error_message = "Failed to update password. Please try again.";
        }
        $update_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | ServiceHub</title>
    <link rel="stylesheet" href="CSS/commonfile.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="dashboard.php" class="auth-logo">ServiceHub</a>
                <h2>Reset Password</h2>
                <p>Create a new password for your account</p>
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
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password" required>
                    <small style="font-size: 12px; color: var(--text-light); margin-top: 5px; display: block;">
                        Password must be at least 6 characters
                    </small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                </div>

                <button type="submit" class="auth-btn">Update Password</button>

                <div class="auth-footer">
                    <p><a href="login.php" style="color: var(--secondary-color);">&larr; Back to Login</a></p>
                </div>
            </form>

            <div class="auth-divider">
                <span>Password Requirements</span>
            </div>
            <div style="text-align: center; font-size: 13px; color: var(--text-light);">
                <p>&#10003; At least 6 characters long</p>
                <p>&#10003; Use a mix of letters and numbers</p>
            </div>
        </div>
    </div>
</body>
</html>
