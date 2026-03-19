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
$missing_fields = [];

// Fetch user data from database
$sql = "SELECT user_id, user_name, user_email_id, phone, address, dob, created_at FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user_data = $result->fetch_assoc();
    
    // Check for missing fields (empty or null) - just for internal use
    if (empty($user_data['phone'])) $missing_fields[] = 'phone';
    if (empty($user_data['address'])) $missing_fields[] = 'address';
    if (empty($user_data['dob'])) $missing_fields[] = 'dob';
} else {
    // User not found - redirect to login
    header("Location: login.php");
    exit();
}

$stmt->close();
$conn->close();

// Format date for display if exists
$formatted_dob = !empty($user_data['dob']) ? date("d F Y", strtotime($user_data['dob'])) : '';
$formatted_member_since = !empty($user_data['created_at']) ? date("F Y", strtotime($user_data['created_at'])) : 'N/A';

include 'header.php';
?>

<!-- ===== MY PROFILE PAGE ===== -->
<!-- Profile Header Section -->
<div class="profile-hero">
    <div class="profile-hero-container">
        <!-- Circular Avatar with shadow - can be dynamic later -->
        <div class="profile-avatar">
            <span>👤</span>
        </div>
        <h1 class="profile-title">My Profile</h1>
        <p class="profile-subtitle">Manage your personal information</p>
    </div>
</div>

<!-- Main content area -->
<div class="profile-content">

    <!-- Profile Information Card -->
    <div class="profile-card">
        <h2 class="card-heading">Personal Details</h2>
        
        <div class="info-grid">
            <!-- Full Name (from database) -->
            <div class="info-row">
                <span class="info-label">Full Name</span>
                <span class="info-value"><?php echo htmlspecialchars($user_data['user_name']); ?></span>
            </div>
            
            <!-- Email Address (from database) -->
            <div class="info-row">
                <span class="info-label">Email Address</span>
                <span class="info-value"><?php echo htmlspecialchars($user_data['user_email_id']); ?></span>
            </div>
            
            <!-- Phone Number - Show "Not added yet" if empty -->
            <div class="info-row">
                <span class="info-label">Phone Number</span>
                <span class="info-value">
                    <?php if (!empty($user_data['phone'])): ?>
                        <?php echo htmlspecialchars($user_data['phone']); ?>
                    <?php else: ?>
                        <span class="missing-data">Not added yet</span>
                    <?php endif; ?>
                </span>
            </div>
            
            <!-- Address - Show "Not added yet" if empty -->
            <div class="info-row">
                <span class="info-label">Address</span>
                <span class="info-value">
                    <?php if (!empty($user_data['address'])): ?>
                        <?php echo htmlspecialchars($user_data['address']); ?>
                    <?php else: ?>
                        <span class="missing-data">Not added yet</span>
                    <?php endif; ?>
                </span>
            </div>
            
            <!-- Date of Birth - Show "Not added yet" if empty -->
            <div class="info-row">
                <span class="info-label">Date of Birth</span>
                <span class="info-value">
                    <?php if (!empty($user_data['dob'])): ?>
                        <?php echo $formatted_dob; ?>
                    <?php else: ?>
                        <span class="missing-data">Not added yet</span>
                    <?php endif; ?>
                </span>
            </div>
            
            <!-- Member since (from database) -->
            <div class="info-row">
                <span class="info-label">Member Since</span>
                <span class="info-value"><?php echo $formatted_member_since; ?></span>
            </div>
        </div>
    </div>

    <!-- Profile Actions Section -->
    <div class="profile-actions">
        <a href="edit-profile.php" class="action-btn btn-edit">Edit Profile</a>
        <a href="change-password.php" class="action-btn btn-password">Change Password</a>
        <!-- Delete Account Button - triggers confirmation dialog -->
        <button onclick="confirmDelete()" class="action-btn btn-delete">Delete Account</button>
    </div>

    <!-- Subtle notification if any fields are missing -->
    <?php if (!empty($missing_fields)): ?>
        <p class="text-center" style="color: var(--text-light); font-size: 14px; margin-top: 15px;">
            ℹ️ Some information is missing. Click <strong>Edit Profile</strong> to complete your profile.
        </p>
    <?php endif; ?>

    <!-- Danger Zone Note -->
    <p style="text-align: center; color: var(--text-light); font-size: 13px; margin-top: 30px; border-top: 1px dashed var(--border-light); padding-top: 20px;">
        ⚠️ Account deletion is permanent and cannot be undone.
    </p>
</div>

<!-- Custom Confirmation Dialog (Modal) -->
<div id="deleteConfirmModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="modal-icon">⚠️</span>
            <h3>Delete Account</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete your account?</p>
            <p style="font-size: 14px; color: var(--text-light); margin-top: 10px;">This action <strong>cannot be undone</strong>. All your data, bookings, and personal information will be permanently removed.</p>
        </div>
        <div class="modal-footer">
            <button onclick="closeModal()" class="action-btn btn-password" style="flex: 1;">Cancel</button>
            <a href="delete-account.php" class="action-btn btn-delete" style="flex: 1; text-align: center; text-decoration: none;">Yes, Delete My Account</a>
        </div>
    </div>
</div>

<style>
/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    animation: fadeIn 0.3s ease;
}

.modal-content {
    background: var(--white);
    margin: 15% auto;
    padding: 0;
    width: 90%;
    max-width: 450px;
    border-radius: 24px;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    animation: slideIn 0.3s ease;
}

.modal-header {
    background: #FEE2E2;
    padding: 25px 30px;
    text-align: center;
    border-bottom: 1px solid #FCA5A5;
}

.modal-header .modal-icon {
    font-size: 48px;
    margin-bottom: 10px;
    display: block;
}

.modal-header h3 {
    color: #DC2626;
    font-size: 24px;
    margin: 0;
    font-weight: 700;
}

.modal-body {
    padding: 30px;
    text-align: center;
}

.modal-body p {
    color: var(--text-medium);
    font-size: 16px;
    line-height: 1.6;
    margin: 0;
}

.modal-body strong {
    color: #DC2626;
}

.modal-footer {
    display: flex;
    gap: 15px;
    padding: 20px 30px 30px;
    border-top: 1px solid var(--border-light);
}

/* Delete button style (red) */
.btn-delete {
    background: #DC2626;
    color: var(--white);
    border: none;
    border-radius: 50px;
    padding: 14px 32px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
    flex: 1;
}

.btn-delete:hover {
    background: #B91C1C;
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(220, 38, 38, 0.3);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .modal-content {
        margin: 30% auto;
        width: 95%;
    }
    
    .modal-footer {
        flex-direction: column;
    }
    
    .modal-header {
        padding: 20px;
    }
    
    .modal-body {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .modal-header h3 {
        font-size: 20px;
    }
    
    .modal-header .modal-icon {
        font-size: 40px;
    }
}
</style>

<script>
// Function to show confirmation modal
function confirmDelete() {
    document.getElementById('deleteConfirmModal').style.display = 'block';
    // Prevent scrolling on body
    document.body.style.overflow = 'hidden';
}

// Function to close modal
function closeModal() {
    document.getElementById('deleteConfirmModal').style.display = 'none';
    // Restore scrolling
    document.body.style.overflow = 'auto';
}

// Close modal if user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById('deleteConfirmModal');
    if (event.target == modal) {
        closeModal();
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>

<?php include 'footer.php'; ?>