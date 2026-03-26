<?php
session_start();

// Include PHPMailer autoloader
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'db_conn.php';

$email = "";
$success_message = "";
$error_message = "";
$email_sent = false;

// Email configuration - Update these with your actual email settings
$smtp_host = 'smtp.gmail.com'; // For Gmail, use smtp.gmail.com
$smtp_port = 587; // 587 for TLS, 465 for SSL
$smtp_username = 'varunpachchigar30@gmail.com'; // Your email address
$smtp_password = 'eyoe gfju zrin fhvn'; // Your email password or app-specific password
$smtp_from_email = 'varunpachchigar30@gmail.com';
$smtp_from_name = 'Fixora Support';

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

            // Store in session
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_code'] = $verification_code;
            $_SESSION['reset_code_expires'] = time() + 600; // 10 minutes expiry
            $_SESSION['reset_user_id'] = $user['user_id'];
            $_SESSION['reset_user_name'] = $user['user_name'];

            // Send email with verification code
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = $smtp_host;
                $mail->SMTPAuth   = true;
                $mail->Username   = $smtp_username;
                $mail->Password   = $smtp_password;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use ENCRYPTION_SMTPS for SSL
                $mail->Port       = $smtp_port;

                // Recipients
                $mail->setFrom($smtp_from_email, $smtp_from_name);
                $mail->addAddress($email, $user['user_name']);
                $mail->addReplyTo($smtp_from_email, $smtp_from_name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request - Fixora';
                
                // Email body HTML
                $mail->Body = '
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Password Reset Code</title>
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
                        .button {
                            display: inline-block;
                            padding: 12px 30px;
                            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
                            color: #1a1a2e;
                            text-decoration: none;
                            border-radius: 5px;
                            font-weight: bold;
                            margin-top: 20px;
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
                            <h2>Hello ' . htmlspecialchars($user['user_name']) . ',</h2>
                            <p>We received a request to reset the password for your Fixora account. Use the verification code below to proceed with resetting your password.</p>
                            
                            <div class="code">
                                ' . $verification_code . '
                            </div>
                            
                            <p>This code will expire in <strong>10 minutes</strong>. If you didn\'t request a password reset, you can safely ignore this email.</p>
                            
                            <p style="margin-top: 30px;">
                                <strong>Need help?</strong> Contact our support team at <a href="mailto:support@fixora.com">support@fixora.com</a>
                            </p>
                            
                            <div class="warning">
                                <strong>Security Note:</strong> Never share this code with anyone. Fixora support will never ask for this code.
                            </div>
                        </div>
                        <div class="footer">
                            <p>&copy; ' . date('Y') . ' Fixora. All rights reserved.<br>
                            This is an automated message, please do not reply to this email.</p>
                        </div>
                    </div>
                </body>
                </html>
                ';
                
                // Plain text alternative for email clients that don't support HTML
                $mail->AltBody = "Hello " . $user['user_name'] . ",\n\n" .
                                "We received a request to reset the password for your Fixora account.\n\n" .
                                "Your verification code is: " . $verification_code . "\n\n" .
                                "This code will expire in 10 minutes.\n\n" .
                                "If you didn't request a password reset, you can safely ignore this email.\n\n" .
                                "Security Note: Never share this code with anyone.\n\n" .
                                "© " . date('Y') . " Fixora. All rights reserved.";

                $mail->send();
                
                $success_message = "Verification code has been sent to your email address!";
                $email_sent = true;
                
                // Redirect after 3 seconds
                header("refresh:3;url=verify-code.php");
                
            } catch (Exception $e) {
                // Log error for debugging (optional)
                error_log("Mailer Error: " . $mail->ErrorInfo);
                $error_message = "Failed to send verification email. Please try again later.";
            }
            
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
    <title>Forgot Password | Fixora</title>
    <link rel="stylesheet" href="CSS/commonfile.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="dashboard.php" class="auth-logo">Fixora</a>
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
                    <p><a href="login.php">&larr; Back to Login</a></p>
                </div>
            </form>

            <div class="auth-divider">
                <span>Need help?</span>
            </div>
            <div style="text-align: center; font-size: 14px;">
                <p>Contact support at <strong>support@fixora.com</strong></p>
            </div>
        </div>
    </div>
</body>
</html>