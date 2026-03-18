<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: Dashboard.php");
    exit();
}

// Include database connection
include 'db_conn.php';

// Initialize variables
$username = $email = "";
$login_error = "";
$registration_success = false;

// Check if this is a redirect from successful registration
if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
    $registration_success = true;
}

// Process login form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $login_input = trim($_POST['login_input']); // Can be username or email
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validation
    if (empty($login_input)) {
        $login_error = "Please enter username or email";
    } elseif (empty($password)) {
        $login_error = "Please enter your password";
    } else {
        // Check if input is email or username
        if (filter_var($login_input, FILTER_VALIDATE_EMAIL)) {
            // Login with email
            $sql = "SELECT user_id, user_name, user_email_id, password, role FROM users WHERE user_email_id = ?";
        } else {
            // Login with username
            $sql = "SELECT user_id, user_name, user_email_id, password, role FROM users WHERE user_name = ?";
        }
        
        // Prepare and execute query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $login_input);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password (plain text for now - you should use password_hash in production)
            if ($password === $user['password']) {
                // Password is correct, start session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['user_name'];
                $_SESSION['user_email'] = $user['user_email_id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['logged_in'] = true;
                
                // Set remember me cookie if requested (30 days)
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    // Store token in database for persistent login (optional)
                    setcookie('remember_token', $token, time() + (86400 * 30), "/"); // 30 days
                }
                
                // Redirect to dashboard
                header("Location: Dashboard.php");
                exit();
            } else {
                $login_error = "Invalid password";
            }
        } else {
            $login_error = "User not found";
        }
        
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ServiceHub</title>
    <link rel="stylesheet" href="CSS/commonfile.css">
</head>

<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="Dashboard.php" class="auth-logo">ServiceHub</a>
                <h2>Welcome Back</h2>
                <p>Sign in to continue to your account</p>
            </div>

            <!-- Success message from registration -->
            <?php if ($registration_success): ?>
                <div class="success-message">
                    Registration successful! Please login with your credentials.
                </div>
            <?php endif; ?>

            <!-- Display Error Message -->
            <?php if (!empty($login_error)): ?>
                <div class="error-message">
                    <?php echo $login_error; ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="login_input">Username or Email</label>
                    <input type="text" id="login_input" name="login_input" 
                           placeholder="Enter your username or email" 
                           value="<?php echo isset($_POST['login_input']) ? htmlspecialchars($_POST['login_input']) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" 
                           placeholder="Enter your password" required>
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember" <?php echo isset($_POST['remember']) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                        Remember me
                    </label>
                    <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="auth-btn">Sign In</button>

                <div class="auth-footer">
                    <p>Don't have an account? <a href="Registration.php">Create Account</a></p>
                </div>
            </form>
           
        </div>
    </div>
</body>
</html>