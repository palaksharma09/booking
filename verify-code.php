<?php
session_start();

// Include PHPMailer autoloader
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'db_conn.php';

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_code'])) {
    header("Location: forgot-password.php");
    exit();
}

if (isset($_SESSION['reset_code_expires']) && time() > $_SESSION['reset_code_expires']) {
    session_unset();
    header("Location: forgot-password.php?expired=1");
    exit();
}

// Email configuration - Same as forgot-password.php
$smtp_host = 'smtp.gmail.com';
$smtp_port = 587;
$smtp_username = 'varunpachchigar30@gmail.com';
$smtp_password = 'eyoe gfju zrin fhvn';
$smtp_from_email = 'varunpachchigar30@gmail.com';
$smtp_from_name = 'Fixora Support';

$error_message = "";
$success_message = "";

// Handle code verification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code'])) {
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
        // Log failed attempt (optional)
        error_log("Failed verification attempt for email: " . $_SESSION['reset_email']);
    }
}

// Handle resend code
if (isset($_GET['resend']) && $_GET['resend'] == 'true') {
    $new_code = rand(100000, 999999);
    $reset_email = $_SESSION['reset_email'];
    $reset_user_name = $_SESSION['reset_user_name'] ?? 'User';
    
    // Update session with new code
    $_SESSION['reset_code'] = $new_code;
    $_SESSION['reset_code_expires'] = time() + 600; // Reset expiry time
    
    // Send new verification code via email
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_username;
        $mail->Password   = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtp_port;
        
        // Recipients
        $mail->setFrom($smtp_from_email, $smtp_from_name);
        $mail->addAddress($reset_email, $reset_user_name);
        $mail->addReplyTo($smtp_from_email, $smtp_from_name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Verification Code - Fixora Password Reset';
        
        // Email body HTML for resend
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>New Verification Code</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #f9f9f9;
                }
                .header {
                    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
                    padding: 30px;
                    text-align: center;
                    border-radius: 10px 10px 0 0;
                }
                .header h1 {
                    color: #ffd700;
                    margin: 0;
                    font-size: 28px;
                }
                .content {
                    background: white;
                    padding: 40px;
                    border-radius: 0 0 10px 10px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                }
                .code {
                    background: #f0f0f0;
                    padding: 20px;
                    text-align: center;
                    font-size: 32px;
                    font-weight: bold;
                    letter-spacing: 5px;
                    color: #1a1a2e;
                    border-radius: 8px;
                    margin: 30px 0;
                    font-family: monospace;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    font-size: 12px;
                    color: #666;
                }
                .warning {
                    color: #ff6b6b;
                    font-size: 12px;
                    margin-top: 20px;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Fixora</h1>
                    <p style="color: white; margin: 10px 0 0;">Professional Services at Your Doorstep</p>
                </div>
                <div class="content">
                    <h2>Hello ' . htmlspecialchars($reset_user_name) . ',</h2>
                    <p>You requested a new verification code for password reset. Use the code below to proceed.</p>
                    
                    <div class="code">
                        ' . $new_code . '
                    </div>
                    
                    <p>This code will expire in <strong>10 minutes</strong>. If you didn\'t request this, please ignore this email.</p>
                    
                    <p style="margin-top: 30px;">
                        <strong>Need help?</strong> Contact our support team at <a href="mailto:support@fixora.com">support@fixora.com</a>
                    </p>
                    
                    <div class="warning">
                        <strong>Security Note:</strong> Never share this code with anyone.
                    </div>
                </div>
                <div class="footer">
                    <p>&copy; ' . date('Y') . ' Fixora. All rights reserved.<br>
                    This is an automated message, please do not reply.</p>
                </div>
            </div>
        </body>
        </html>
        ';
        
        $mail->AltBody = "Hello " . $reset_user_name . ",\n\n" .
                        "You requested a new verification code for password reset.\n\n" .
                        "Your new verification code is: " . $new_code . "\n\n" .
                        "This code will expire in 10 minutes.\n\n" .
                        "If you didn't request this, please ignore this email.\n\n" .
                        "© " . date('Y') . " Fixora. All rights reserved.";
        
        $mail->send();
        
        $success_message = "New verification code has been sent to your email address!";
        
    } catch (Exception $e) {
        error_log("Mailer Error (Resend): " . $mail->ErrorInfo);
        $error_message = "Failed to send new verification code. Please try again later.";
    }
}

$conn->close();
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
                    <small style="font-size: 12px; color: #666; margin-top: 5px; display: block;">
                        Enter the 6-digit code sent to your email
                    </small>
                </div>

                <button type="submit" class="auth-btn">Verify Code</button>

                <div class="auth-footer">
                    <p>Didn't receive the code? <a href="?resend=true">Resend Code</a></p>
                    <p style="margin-top: 15px;"><a href="forgot-password.php">&larr; Back to Forgot Password</a></p>
                </div>
            </form>

            <div class="auth-divider">
                <span>Check your inbox</span>
            </div>
            <div style="text-align: center; font-size: 13px; color: #666;">
                <p>Code expires in 10 minutes</p>
                <p style="margin-top: 5px;">Also check your spam folder</p>
            </div>
        </div>
    </div>

    <script>
    // Auto-format and restrict input to numbers only
    const codeInput = document.getElementById('code');
    codeInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });
    
    // Optional: Auto-submit when 6 digits are entered
    codeInput.addEventListener('keyup', function() {
        if (this.value.length === 6) {
            this.form.submit();
        }
    });
    </script>
</body>
</html>