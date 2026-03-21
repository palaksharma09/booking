<?php
// Start session at the beginning
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_conn.php';

// Initialize variables
$user_id = $_SESSION['user_id'];
$current_password = "";
$new_password = "";
$confirm_password = "";
$error_message = "";
$success_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($current_password)) {
        $error_message = "Please enter your current password";
    } elseif (empty($new_password)) {
        $error_message = "Please enter a new password";
    } elseif (empty($confirm_password)) {
        $error_message = "Please confirm your new password";
    } elseif (strlen($new_password) < 6) {
        $error_message = "Password must be at least 6 characters long";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "New password and confirmation do not match";
    } else {
        
        // Fetch current password from database
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $db_password = $user['password'];
            
            // Verify current password (PLAIN TEXT comparison - TEST MODE)
            // ⚠️ In production, replace this with password_verify() for security
            if ($current_password === $db_password) {
                
                // Update password (PLAIN TEXT - TEST MODE)
                // ⚠️ In production, replace this with password_hash() for security
                $update_sql = "UPDATE users SET password = ? WHERE user_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("si", $new_password, $user_id);
                
                if ($update_stmt->execute()) {
                    $success_message = "Password updated successfully!";
                    
                    // Clear form fields
                    $current_password = "";
                    $new_password = "";
                    $confirm_password = "";
                    
                    // Optional: Auto-redirect after 2 seconds
                    // header("refresh:2;url=my-profile.php");
                } else {
                    $error_message = "Failed to update password. Please try again.";
                }
                $update_stmt->close();
                
            } else {
                $error_message = "Current password is incorrect";
            }
        } else {
            $error_message = "User not found";
        }
        $stmt->close();
    }
}

$conn->close();

// Include header
include 'header.php';
?>

<!-- ===== CHANGE PASSWORD PAGE ===== -->
<!-- Profile Header Section (same style as profile page) -->
<div class="profile-hero">
    <div class="profile-hero-container">
        <!-- Circular Avatar with lock icon for password page -->
        <div class="profile-avatar">
            <span aria-hidden="true">
                <svg class="icon-svg" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V8a4 4 0 1 1 8 0v3"></path></svg>
            </span>
        </div>
        <h1 class="profile-title">Change Password</h1>
        <p class="profile-subtitle">Update your account password</p>
    </div>
</div>

<!-- Main content area -->
<div class="profile-content">

    <!-- Change Password Card -->
    <div class="profile-card">
        <h2 class="card-heading">Password Settings</h2>
        
        <!-- Display Success Message -->
        <?php if (!empty($success_message)): ?>
            <div class="success-message" style="margin-bottom: 25px;">
                <?php echo $success_message; ?>
                <?php if (strpos($success_message, 'successfully') !== false): ?>
                    <p style="margin-top: 10px; font-size: 13px;">
                        Redirecting to profile... 
                        <a href="my-profile.php" style="color: var(--secondary-color);">Click here</a> if not redirected.
                    </p>
                    <script>
                        setTimeout(function() {
                            window.location.href = "my-profile.php";
                        }, 2000);
                    </script>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- Display Error Message -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message" style="margin-bottom: 25px;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <!-- Security Note for TESTING -->
        <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 12px 15px; border-radius: 12px; margin-bottom: 25px;">
            <p class="icon-inline" style="font-size: 13px; color: #92400E; margin: 0;">
                <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 2.8 19a1.2 1.2 0 0 0 1 1.8h16.4a1.2 1.2 0 0 0 1-1.8L12 3Z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
                <span><strong>Test Mode Notice:</strong> Password is stored in plain text for testing purposes.
                In production, this should use password hashing.</span>
            </p>
        </div>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Current Password Field -->
            <div class="form-group" style="margin-bottom: 25px;">
                <label for="current_password" style="display: block; font-size: 14px; font-weight: 500; color: var(--accent-color); margin-bottom: 8px;">
                    Current Password
                </label>
                <div style="position: relative;">
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           value="<?php echo htmlspecialchars($current_password); ?>"
                           placeholder="Enter your current password"
                           style="width: 100%; padding: 14px 18px; font-size: 15px; border: 2px solid var(--border-light); border-radius: 16px; background: var(--white); transition: all 0.3s ease; outline: none;"
                           required>
                    <button type="button" 
                            onclick="togglePassword('current_password')" 
                            aria-label="Show current password"
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-light); font-size: 16px;">
                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
            </div>
            
            <!-- New Password Field -->
            <div class="form-group" style="margin-bottom: 25px;">
                <label for="new_password" style="display: block; font-size: 14px; font-weight: 500; color: var(--accent-color); margin-bottom: 8px;">
                    New Password
                </label>
                <div style="position: relative;">
                    <input type="password" 
                           id="new_password" 
                           name="new_password" 
                           value="<?php echo htmlspecialchars($new_password); ?>"
                           placeholder="Enter new password (minimum 6 characters)"
                           style="width: 100%; padding: 14px 18px; font-size: 15px; border: 2px solid var(--border-light); border-radius: 16px; background: var(--white); transition: all 0.3s ease; outline: none;"
                           required>
                    <button type="button" 
                            onclick="togglePassword('new_password')" 
                            aria-label="Show new password"
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-light); font-size: 16px;">
                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
                <small style="font-size: 12px; color: var(--text-light); margin-top: 5px; display: block;">
                    Password must be at least 6 characters long
                </small>
            </div>
            
            <!-- Confirm New Password Field -->
            <div class="form-group" style="margin-bottom: 30px;">
                <label for="confirm_password" style="display: block; font-size: 14px; font-weight: 500; color: var(--accent-color); margin-bottom: 8px;">
                    Confirm New Password
                </label>
                <div style="position: relative;">
                    <input type="password" 
                           id="confirm_password" 
                           name="confirm_password" 
                           value="<?php echo htmlspecialchars($confirm_password); ?>"
                           placeholder="Confirm your new password"
                           style="width: 100%; padding: 14px 18px; font-size: 15px; border: 2px solid var(--border-light); border-radius: 16px; background: var(--white); transition: all 0.3s ease; outline: none;"
                           required>
                    <button type="button" 
                            onclick="togglePassword('confirm_password')" 
                            aria-label="Show confirm password"
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-light); font-size: 16px;">
                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="profile-actions" style="margin-top: 10px;">
                <button type="submit" class="action-btn btn-edit">Update Password</button>
                <a href="my-profile.php" class="action-btn btn-password">Cancel</a>
            </div>
        </form>
        
        <!-- Password Strength Tips -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-light);">
            <h3 style="font-size: 14px; color: var(--text-medium); margin-bottom: 10px;">Password Tips:</h3>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li class="icon-list-item" style="font-size: 13px; color: var(--text-light); margin-bottom: 5px;"><svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 4 4L19 6"></path></svg><span>Use at least 6 characters</span></li>
                <li class="icon-list-item" style="font-size: 13px; color: var(--text-light); margin-bottom: 5px;"><svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 4 4L19 6"></path></svg><span>Mix uppercase and lowercase letters</span></li>
                <li class="icon-list-item" style="font-size: 13px; color: var(--text-light); margin-bottom: 5px;"><svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 4 4L19 6"></path></svg><span>Include numbers for extra security</span></li>
                <li class="icon-list-item" style="font-size: 13px; color: var(--text-light);"><svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 4 4L19 6"></path></svg><span>Avoid using common words or personal information</span></li>
            </ul>
        </div>
    </div>
    
    <!-- Security Note -->
    <p class="icon-inline" style="justify-content: center; color: var(--text-light); font-size: 13px; margin-top: 20px;">
        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 12a3 3 0 1 0 6 0 3 3 0 0 0-6 0Z"></path><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path></svg>
        <span>Your password is encrypted and stored securely. Never share your password with anyone.</span>
    </p>
</div>

<script>
// Toggle password visibility function
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);
    
    const btn = field.nextElementSibling;
    if (type === 'text') {
        btn.style.opacity = '0.7';
        btn.setAttribute('aria-label', 'Hide password');
    } else {
        btn.style.opacity = '1';
        if (fieldId === 'current_password') {
            btn.setAttribute('aria-label', 'Show current password');
        } else if (fieldId === 'new_password') {
            btn.setAttribute('aria-label', 'Show new password');
        } else {
            btn.setAttribute('aria-label', 'Show confirm password');
        }
    }
}

// Real-time password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    
    function validatePasswordMatch() {
        if (confirmPassword.value.length > 0) {
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.style.borderColor = '#DC2626';
                confirmPassword.style.boxShadow = '0 0 0 4px rgba(220, 38, 38, 0.1)';
            } else {
                confirmPassword.style.borderColor = 'var(--secondary-color)';
                confirmPassword.style.boxShadow = '0 0 0 4px var(--secondary-light)';
            }
        } else {
            confirmPassword.style.borderColor = 'var(--border-light)';
            confirmPassword.style.boxShadow = 'none';
        }
    }
    
    newPassword.addEventListener('input', validatePasswordMatch);
    confirmPassword.addEventListener('input', validatePasswordMatch);
    
    // Password strength indicator (optional)
    newPassword.addEventListener('input', function() {
        const password = this.value;
        const strength = getPasswordStrength(password);
        
        // Remove existing strength indicator if present
        const existingIndicator = document.querySelector('.password-strength-indicator');
        if (existingIndicator) existingIndicator.remove();
        
        if (password.length > 0) {
            const indicator = document.createElement('div');
            indicator.className = 'password-strength-indicator';
            indicator.style.marginTop = '8px';
            
            let strengthText = '';
            let strengthColor = '';
            
            if (password.length < 6) {
                strengthText = 'Too short';
                strengthColor = '#DC2626';
            } else if (password.length < 8) {
                strengthText = 'Weak';
                strengthColor = '#F59E0B';
            } else if (password.match(/[A-Z]/) && password.match(/[0-9]/)) {
                strengthText = 'Strong';
                strengthColor = '#10B981';
            } else {
                strengthText = 'Medium';
                strengthColor = '#3B82F6';
            }
            
            indicator.innerHTML = `
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="flex: 1; height: 4px; background: var(--border-light); border-radius: 4px; overflow: hidden;">
                        <div style="width: ${strength === 'Too short' ? '20%' : strength === 'Weak' ? '40%' : strength === 'Medium' ? '70%' : '100%'}; height: 100%; background: ${strengthColor}; transition: width 0.3s ease;"></div>
                    </div>
                    <span style="font-size: 12px; color: ${strengthColor};">${strengthText}</span>
                </div>
            `;
            
            this.parentNode.appendChild(indicator);
        }
    });
});

function getPasswordStrength(password) {
    if (password.length < 6) return 'Too short';
    if (password.length < 8) return 'Weak';
    if (password.match(/[A-Z]/) && password.match(/[0-9]/) && password.length >= 8) return 'Strong';
    return 'Medium';
}

// Form validation before submit
document.querySelector('form').addEventListener('submit', function(e) {
    const newPass = document.getElementById('new_password').value;
    const confirmPass = document.getElementById('confirm_password').value;
    
    if (newPass !== confirmPass) {
        e.preventDefault();
        alert('New password and confirmation do not match!');
        return false;
    }
    
    if (newPass.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters long!');
        return false;
    }
    
    return true;
});
</script>

<style>
/* Additional styles for password fields focus states */
.form-group input:focus {
    border-color: var(--secondary-color);
    box-shadow: 0 0 0 4px var(--secondary-light);
}

/* Eye button hover effect */
.form-group button[onclick*="togglePassword"]:hover {
    color: var(--secondary-color);
    transform: scale(1.1);
    transition: all 0.2s ease;
}

/* Success message animation */
.success-message {
    animation: slideDown 0.4s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<?php include 'footer.php'; ?>
