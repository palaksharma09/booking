<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

include 'db_conn.php';

$username = $email = "";
$login_error = "";
$registration_success = false;

if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
    $registration_success = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_input = trim($_POST['login_input']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if (empty($login_input)) {
        $login_error = "Please enter username or email";
    } elseif (empty($password)) {
        $login_error = "Please enter your password";
    } else {
        if (filter_var($login_input, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT user_id, user_name, user_email_id, password, role FROM users WHERE user_email_id = ?";
        } else {
            $sql = "SELECT user_id, user_name, user_email_id, password, role FROM users WHERE user_name = ?";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $login_input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['user_name'];
                $_SESSION['user_email'] = $user['user_email_id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['logged_in'] = true;

                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (86400 * 30), "/");
                }

                header("Location: dashboard.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper input {
            width: 100%;
            padding: 15px 18px;
            padding-right: 50px;
            font-size: 15px;
            border: 2px solid var(--border-light);
            border-radius: 16px;
            background: var(--white);
            color: var(--text-dark);
            transition: all 0.3s ease;
            outline: none;
        }

        .password-wrapper input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px var(--secondary-light);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: var(--text-light);
            transition: var(--transition-fast);
            background: transparent;
            border: none;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password:hover {
            color: var(--secondary-color);
        }

        .goodbye-message {
            background: #FEE2E2;
            color: #DC2626;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #FCA5A5;
            animation: slideUp 0.3s ease-out;
        }

        .goodbye-message span {
            margin-right: 8px;
        }
    </style>
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="dashboard.php" class="auth-logo">ServiceHub</a>
                <h2>Welcome Back</h2>
                <p>Sign in to continue to your account</p>
            </div>

            <?php if ($registration_success): ?>
                <div class="success-message">
                    Registration successful! Please login with your credentials.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['reset']) && $_GET['reset'] === 'success'): ?>
                <div class="success-message">
                    Password updated successfully. Please sign in with your new password.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['account_deleted']) && $_GET['account_deleted'] == 'success'): ?>
                <div class="goodbye-message">
                    <span><i class="fa-regular fa-hand"></i></span>Your account has been successfully deleted. We're sorry to see you go!
                </div>
            <?php endif; ?>

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
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', this)" aria-label="Show password">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
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

    <script>
    function togglePasswordVisibility(fieldId, trigger) {
        const passwordInput = document.getElementById(fieldId);
        const toggleIcon = trigger.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.className = 'fa-regular fa-eye-slash';
            trigger.setAttribute('aria-label', 'Hide password');
        } else {
            passwordInput.type = 'password';
            toggleIcon.className = 'fa-regular fa-eye';
            trigger.setAttribute('aria-label', 'Show password');
        }
    }
    </script>
</body>
</html>
