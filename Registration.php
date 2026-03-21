<?php
session_start();
include 'db_conn.php';

$username = $email = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        $check_username = $conn->prepare("SELECT user_id FROM users WHERE user_name = ?");
        $check_username->bind_param("s", $username);
        $check_username->execute();
        $check_username->store_result();

        if ($check_username->num_rows > 0) {
            $errors[] = "Username already taken";
        }
        $check_username->close();
    }

    if (empty($errors)) {
        $check_email = $conn->prepare("SELECT user_id FROM users WHERE user_email_id = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $check_email->store_result();

        if ($check_email->num_rows > 0) {
            $errors[] = "Email already registered";
        }
        $check_email->close();
    }

    if (empty($errors)) {
        $role = 'user';
        $insert_sql = "INSERT INTO users (user_name, user_email_id, password, role) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssss", $username, $email, $password, $role);

        if ($insert_stmt->execute()) {
            $_SESSION['registration_success'] = true;
            $_SESSION['registered_email'] = $email;
            header("Location: login.php?registration=success");
            exit();
        } else {
            $errors[] = "Registration failed: " . $conn->error;
        }

        $insert_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ServiceHub</title>
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

        .form-row .password-wrapper {
            width: 100%;
        }

        .password-strength {
            margin-top: 8px;
            display: flex;
            gap: 5px;
        }

        .strength-bar {
            height: 4px;
            flex: 1;
            background: var(--border-light);
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .strength-text {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 5px;
        }
    </style>
</head>
<body class="auth-body">
    <div class="auth-container auth-container-wide">
        <div class="auth-card">
            <div class="auth-header">
                <a href="dashboard.php" class="auth-logo">ServiceHub</a>
                <h2>Create Account</h2>
                <p>Join thousands of trusted professionals and customers</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <p style="margin-bottom: 5px;"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username"
                           value="<?php echo htmlspecialchars($username); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                           value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Create password" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', this)" aria-label="Show password">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength" id="password-strength" style="display: none;">
                            <div class="strength-bar"></div>
                            <div class="strength-bar"></div>
                            <div class="strength-bar"></div>
                        </div>
                        <span class="strength-text" id="strength-text"></span>
                    </div>

                    <div class="form-group half">
                        <label for="confirm-password">Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm password" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirm-password', this)" aria-label="Show password">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group terms-group">
                    <label class="checkbox-container">
                        <input type="checkbox" name="terms" required>
                        <span class="checkmark"></span>
                        <span>I agree to the <a href="terms.php" class="terms-link">Terms of Service</a> and <a href="privacy.php" class="terms-link">Privacy Policy</a></span>
                    </label>
                </div>

                <button type="submit" class="auth-btn">Create Account</button>

                <div class="auth-footer">
                    <p>Already have an account? <a href="login.php">Sign In</a></p>
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

    document.getElementById('password')?.addEventListener('input', function() {
        const password = this.value;
        const strengthBars = document.querySelectorAll('.strength-bar');
        const strengthText = document.getElementById('strength-text');
        const strengthContainer = document.getElementById('password-strength');

        if (password.length === 0) {
            strengthContainer.style.display = 'none';
            strengthText.textContent = '';
            return;
        }

        strengthContainer.style.display = 'flex';

        let strength = 0;
        if (password.length >= 6) strength++;
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        let barCount = Math.min(3, Math.ceil(strength / 2));

        strengthBars.forEach(bar => {
            bar.style.background = 'var(--border-light)';
        });

        for (let i = 0; i < barCount; i++) {
            if (barCount === 1) {
                strengthBars[i].style.background = '#EF4444';
            } else if (barCount === 2) {
                strengthBars[i].style.background = '#F59E0B';
            } else {
                strengthBars[i].style.background = 'var(--secondary-color)';
            }
        }

        if (barCount === 1) {
            strengthText.textContent = 'Weak password';
            strengthText.style.color = '#EF4444';
        } else if (barCount === 2) {
            strengthText.textContent = 'Medium password';
            strengthText.style.color = '#F59E0B';
        } else {
            strengthText.textContent = 'Strong password';
            strengthText.style.color = 'var(--secondary-color)';
        }
    });
    </script>
</body>
</html>
