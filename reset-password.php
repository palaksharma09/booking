<?php
session_start();

// Check if user has verified the code
if (!isset($_SESSION['reset_verified']) || $_SESSION['reset_verified'] !== true) {
    header("Location: forgot-password.php");
    exit();
}

// Check if reset email exists
if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_user_id'])) {
    header("Location: forgot-password.php");
    exit();
}

// Include database connection
include 'db_conn.php';

$password = "";
$confirm_password = "";
$error_message = "";
$success_message = "";

// Process password reset
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($password)) {
        $error_message = "Please enter a new password";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters";
    } elseif ($password != $confirm_password) {
        $error_message = "Passwords do not match";
    } else {
        // Update password in database
        $user_id = $_SESSION['reset_user_id'];
        
        // For production, use password_hash()
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $password, $user_id);
        
        if ($update_stmt->execute()) {
            // Password updated successfully
            $success_message = "Password updated successfully! Redirecting to login...";
            
            // Clear all reset session variables
            unset($_SESSION['reset_email']);
            unset($_SESSION['reset_code']);
            unset($_SESSION['reset_code_expires']);
            unset($_SESSION['reset_user_id']);
            unset($_SESSION['reset_verified']);
            
            // Redirect to login after 3 seconds
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
                <a href="Dashboard.php" class="auth-logo">ServiceHub</a>
                <h2>Reset Password</h2>
                <p>Create a new password for your account</p>
            </div>

            <!-- Success Message -->
            <?php if (!empty($success_message)): ?>
                <div class="success-message">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <!-- Error Message -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" 
                           placeholder="Enter new password" 
                           required>
                    <small style="font-size: 12px; color: var(--text-light); margin-top: 5px; display: block;">
                        Password must be at least 6 characters
                    </small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" 
                           placeholder="Confirm new password" 
                           required>
                </div>

                <button type="submit" class="auth-btn">Update Password</button>

                <div class="auth-footer">
                    <p><a href="login.php" style="color: var(--secondary-color);">← Back to Login</a></p>
                </div>
            </form>

            <div class="auth-divider">
                <span>Password Requirements</span>
            </div>
            <div style="text-align: center; font-size: 13px; color: var(--text-light);">
                <p>✓ At least 6 characters long</p>
                <p>✓ Use a mix of letters and numbers</p>
            </div>
        </div>
    </div>
</body>
</html>