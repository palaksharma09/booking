<!DOCTYPE html>
<html>
<head>
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

            <form class="auth-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Enter your username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Enter your password" required>
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" checked>
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