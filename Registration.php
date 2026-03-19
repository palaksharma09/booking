<?php
session_start();
include 'db_conn.php';

// Initialize variables
$username = $email = "";
$errors = [];

// Process registration form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
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
    
    // Check if username already exists
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
    
    // Check if email already exists
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
    
    // If no errors, insert into database
    if (empty($errors)) {
        // Hash the password for security
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Default role is 'user' (not admin)
        $role = 'user';
        
        // Prepare insert statement
        $insert_sql = "INSERT INTO users (user_name, user_email_id, password, role) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssss", $username, $email, $password, $role);
        
        if ($insert_stmt->execute()) {
            // Registration successful
            $_SESSION['registration_success'] = true;
            $_SESSION['registered_email'] = $email;
            
            // Redirect to login page with success message
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
    <style>
        /* Password field with eye icon */
        .password-wrapper {
            position: relative;
            width: 100%;
        }
        
        .password-wrapper input {
            width: 100%;
            padding: 15px 18px;
            padding-right: 50px; /* Space for eye icon */
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
            font-size: 20px;
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
        
        /* Adjust for half-width inputs in form row */
        .form-row .password-wrapper {
            width: 100%;
        }
        
        /* Password strength indicator (optional enhancement) */
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

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="Dashboard.php" class="auth-logo">ServiceHub</a>
                <h2>Create Account</h2>
                <p>Join thousands of trusted professionals and customers</p>
            </div>

            <!-- Display Error Messages -->
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
                            <span class="toggle-password" onclick="togglePasswordVisibility('password')">👁️</span>
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
                            <span class="toggle-password" onclick="togglePasswordVisibility('confirm-password')">👁️</span>
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
    function togglePasswordVisibility(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const toggleIcon = event.currentTarget;
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = '🔒';
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = '👁️';
        }
    }
    
    // Optional: Password strength indicator (enhancement)
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
        
        // Simple password strength check
        let strength = 0;
        if (password.length >= 6) strength++;
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        // Normalize to 3 bars
        let barCount = Math.min(3, Math.ceil(strength / 2));
        
        // Reset bars
        strengthBars.forEach(bar => {
            bar.style.background = 'var(--border-light)';
        });
        
        // Fill bars based on strength
        for (let i = 0; i < barCount; i++) {
            if (barCount === 1) {
                strengthBars[i].style.background = '#EF4444'; // Weak - Red
            } else if (barCount === 2) {
                strengthBars[i].style.background = '#F59E0B'; // Medium - Orange
            } else {
                strengthBars[i].style.background = 'var(--secondary-color)'; // Strong - Green
            }
        }
        
        // Set strength text
        if (barCount === 1) {
            strengthText.textContent = 'Weak password';
            strengthText.style.color = '#EF4444';
        } else if (barCount === 2) {
            strengthText.textContent = 'Medium password';
            strengthText.style.color = '#F59E0B';
        } else if (barCount >= 3) {
            strengthText.textContent = 'Strong password';
            strengthText.style.color = 'var(--secondary-color)';
        }
    });
    </script>
</body>
</html>