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

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Initialize variables
$user_data = [];
$success_message = '';
$error_message = '';

// Fetch current user data
$sql = "SELECT user_name, user_email_id, phone, address, dob FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user_data = $result->fetch_assoc();
} else {
    // User not found - redirect to login
    header("Location: login.php");
    exit();
}
$stmt->close();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $dob = !empty($_POST['dob']) ? $_POST['dob'] : null;
    
    // Validation
    $errors = [];
    
    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters";
    }
    
    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Check if username already exists (excluding current user)
    $check_username = $conn->prepare("SELECT user_id FROM users WHERE user_name = ? AND user_id != ?");
    $check_username->bind_param("si", $username, $user_id);
    $check_username->execute();
    $check_username->store_result();
    
    if ($check_username->num_rows > 0) {
        $errors[] = "Username already taken";
    }
    $check_username->close();
    
    // Check if email already exists (excluding current user)
    $check_email = $conn->prepare("SELECT user_id FROM users WHERE user_email_id = ? AND user_id != ?");
    $check_email->bind_param("si", $email, $user_id);
    $check_email->execute();
    $check_email->store_result();
    
    if ($check_email->num_rows > 0) {
        $errors[] = "Email already registered";
    }
    $check_email->close();
    
    // Phone validation (optional)
    if (!empty($phone) && !preg_match('/^[0-9+\-\s()]{10,20}$/', $phone)) {
        $errors[] = "Please enter a valid phone number";
    }
    
    // If no errors, update database
    if (empty($errors)) {
        $update_sql = "UPDATE users SET user_name = ?, user_email_id = ?, phone = ?, address = ?, dob = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssssi", $username, $email, $phone, $address, $dob, $user_id);
        
        if ($update_stmt->execute()) {
            $success_message = "Profile updated successfully!";
            
            // Update session data
            $_SESSION['username'] = $username;
            $_SESSION['user_email'] = $email;
            
            // Refresh user data
            $refresh_sql = "SELECT user_name, user_email_id, phone, address, dob FROM users WHERE user_id = ?";
            $refresh_stmt = $conn->prepare($refresh_sql);
            $refresh_stmt->bind_param("i", $user_id);
            $refresh_stmt->execute();
            $refresh_result = $refresh_stmt->get_result();
            $user_data = $refresh_result->fetch_assoc();
            $refresh_stmt->close();
        } else {
            $error_message = "Error updating profile: " . $conn->error;
        }
        $update_stmt->close();
    }
}

$conn->close();

include 'header.php';
?>

<!-- ===== EDIT PROFILE PAGE ===== -->
<div class="profile-content" style="max-width: 700px;">
    
    <!-- Success/Error Messages using existing styles -->
    <?php if ($success_message): ?>
        <div class="success-message icon-inline" style="margin-bottom: 25px; align-items: center;">
            <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 4 4L19 6"></path></svg>
            <span><?php echo $success_message; ?></span>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error-message icon-inline" style="margin-bottom: 25px; align-items: center;">
            <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="m9 9 6 6"></path><path d="m15 9-6 6"></path></svg>
            <span><?php echo $error_message; ?></span>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($errors)): ?>
        <div class="error-message" style="margin-bottom: 25px;">
            <div class="icon-inline" style="margin-bottom: 6px;">
                <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 2.8 19a1.2 1.2 0 0 0 1 1.8h16.4a1.2 1.2 0 0 0 1-1.8L12 3Z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
                <span>Please review the following:</span>
            </div>
            <?php foreach ($errors as $error): ?>
                <?php echo $error; ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Edit Profile Card - Using existing profile-card class -->
    <div class="profile-card">
        <h2 class="card-heading">Edit Profile</h2>
        <p style="color: var(--text-medium); margin-bottom: 25px; font-size: 15px;">
            Update your personal information. All fields can be edited.
        </p>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Username -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="username" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--accent-color);">
                    Username <span style="color: var(--secondary-color);">*</span>
                </label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       class="form-control" 
                       style="width: 100%; padding: 14px 18px; border: 2px solid var(--border-light); border-radius: 16px; font-size: 15px; transition: all 0.3s ease;"
                       value="<?php echo htmlspecialchars($user_data['user_name']); ?>" 
                       required>
                <small style="color: var(--text-light); font-size: 12px; margin-top: 5px; display: block;">
                    Minimum 3 characters
                </small>
            </div>
            
            <!-- Email -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--accent-color);">
                    Email Address <span style="color: var(--secondary-color);">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control" 
                       style="width: 100%; padding: 14px 18px; border: 2px solid var(--border-light); border-radius: 16px; font-size: 15px; transition: all 0.3s ease;"
                       value="<?php echo htmlspecialchars($user_data['user_email_id']); ?>" 
                       required>
            </div>
            
            <!-- Phone (Optional) -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--accent-color);">
                    Phone Number <span style="color: var(--text-light); font-size: 12px; font-weight: normal;">(optional)</span>
                </label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       class="form-control" 
                       style="width: 100%; padding: 14px 18px; border: 2px solid var(--border-light); border-radius: 16px; font-size: 15px; transition: all 0.3s ease;"
                       placeholder="e.g., +91 98765 43210"
                       value="<?php echo htmlspecialchars($user_data['phone'] ?? ''); ?>">
            </div>
            
            <!-- Address (Optional) -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="address" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--accent-color);">
                    Address <span style="color: var(--text-light); font-size: 12px; font-weight: normal;">(optional)</span>
                </label>
                <textarea id="address" 
                          name="address" 
                          class="form-control" 
                          style="width: 100%; padding: 14px 18px; border: 2px solid var(--border-light); border-radius: 16px; font-size: 15px; transition: all 0.3s ease; min-height: 100px; resize: vertical;"
                          placeholder="Enter your full address"><?php echo htmlspecialchars($user_data['address'] ?? ''); ?></textarea>
            </div>
            
            <!-- Date of Birth (Optional) -->
            <div class="form-group" style="margin-bottom: 30px;">
                <label for="dob" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--accent-color);">
                    Date of Birth <span style="color: var(--text-light); font-size: 12px; font-weight: normal;">(optional)</span>
                </label>
                <input type="date" 
                       id="dob" 
                       name="dob" 
                       class="form-control" 
                       style="width: 100%; padding: 14px 18px; border: 2px solid var(--border-light); border-radius: 16px; font-size: 15px; transition: all 0.3s ease;"
                       value="<?php echo htmlspecialchars($user_data['dob'] ?? ''); ?>">
            </div>
            
            <!-- Form Actions using existing action-btn classes -->
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button type="submit" class="action-btn btn-edit" style="border: none; cursor: pointer; flex: 2;">
                    Save Changes
                </button>
                <a href="my-profile.php" class="action-btn btn-password" style="text-align: center; flex: 1;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
    
    <!-- Simple info note -->
    <p class="icon-inline" style="justify-content: center; color: var(--text-light); font-size: 14px; margin-top: 20px;">
        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M12 11v5"></path><path d="M12 8h.01"></path></svg>
        <span>Fields marked with <span style="color: var(--secondary-color);">*</span> are required</span>
    </p>
</div>

<style>
/* Minimal additional styles - only what's absolutely necessary */
.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--secondary-color) !important;
    box-shadow: 0 0 0 4px var(--secondary-light) !important;
    outline: none;
}

.form-group input.error,
.form-group textarea.error {
    border-color: #DC2626 !important;
}

@media (max-width: 768px) {
    .profile-content {
        padding: 0 15px;
    }
    
    .profile-card {
        padding: 25px 20px !important;
    }
    
    div[style*="display: flex; gap: 15px;"] {
        flex-direction: column;
    }
}
</style>

<?php include 'footer.php'; ?>
