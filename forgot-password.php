<?php
session_start();

// Include database connection
include 'db_conn.php';

$email = "";
$success_message = "";
$error_message = "";
$email_sent = false;

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    
    if (empty($email)) {
        $error_message = "Please enter your email address";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address";
    } else {
        // Check if email exists in database
        $check_sql = "SELECT user_id, user_name FROM users WHERE user_email_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Generate a 6-digit verification code
            $verification_code = rand(100000, 999999);
            
            // Store code in session with expiration (10 minutes)
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_code'] = $verification_code;
            $_SESSION['reset_code_expires'] = time() + 600; // 10 minutes
            $_SESSION['reset_user_id'] = $user['user_id'];
            
            // In a real application, you would send an email here
            // For demo purposes, we'll show the code in a success message
            
            $success_message = "Verification code sent! Your code is: <strong>$verification_code</strong><br>
                                (In production, this would be sent to your email)";
            $email_sent = true;
            
            // Redirect after 3 seconds to verification page (optional)
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
                <a href="Dashboard.php" class="auth-logo">ServiceHub</a>
                <h2>Forgot Password?</h2>
                <p>Enter your email to receive a verification code</p>
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
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" 
                           placeholder="Enter your registered email" 
                           value="<?php echo htmlspecialchars($email); ?>" 
                           required>
                </div>

                <button type="submit" class="auth-btn">Send Code</button>

                <div class="auth-footer">
                    <p><a href="login.php" style="color: var(--secondary-color);">← Back to Login</a></p>
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