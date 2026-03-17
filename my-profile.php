<?php include 'header.php'; ?>

<!-- ===== MY PROFILE PAGE ===== -->
<!-- Profile Header Section -->
<div class="profile-hero">
    <div class="profile-hero-container">
        <!-- Circular Avatar with shadow -->
        <div class="profile-avatar">
            <!-- Using a user icon as avatar; you can replace with dynamic image later -->
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
            <!-- Full Name -->
            <div class="info-row">
                <span class="info-label">Full Name</span>
                <span class="info-value">Rahul Sharma</span>
            </div>
            <!-- Email Address -->
            <div class="info-row">
                <span class="info-label">Email Address</span>
                <span class="info-value">rahul.sharma@example.com</span>
            </div>
            <!-- Phone Number (optional) -->
            <div class="info-row">
                <span class="info-label">Phone Number</span>
                <span class="info-value">+91 98765 43210</span>
            </div>
            <!-- Account Role -->
            <div class="info-row">
                <span class="info-label">Account Role</span>
                <span class="info-value role-badge">User</span>
            </div>
            <!-- Member since (extra touch) -->
            <div class="info-row">
                <span class="info-label">Member Since</span>
                <span class="info-value">January 2024</span>
            </div>
        </div>
    </div>

    <!-- Profile Actions Section -->
    <div class="profile-actions">
        <a href="edit-profile.php" class="action-btn btn-edit">Edit Profile</a>
        <a href="change-password.php" class="action-btn btn-password">Change Password</a>
        <a href="logout.php" class="action-btn btn-logout">Logout</a>
    </div>

    <!-- Optional note about future update feature -->
    <p class="future-note">✨ Profile update feature coming soon – you'll be able to edit your details directly.</p>
</div>

<?php include 'footer.php'; ?>


