<?php
/**
 * Admin Header with Sidebar
 * Include this at the top of each admin page
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Fixora</title>
    <link rel="stylesheet" href="../CSS/commonfile.css">
    <link rel="stylesheet" href="admin-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="admin-header-container">
            <div class="admin-header-left">
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <a href="dashboard.php" class="admin-logo">
                    <img src="../logo/logo.png" alt="Fixora Admin" class="admin-logo-img">
                    <span class="admin-label">Admin</span>
                </a>
            </div>

            <div class="admin-header-right">
                <div class="admin-user-info">
                    <span class="admin-user-name"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                    <span class="admin-user-role">Administrator</span>
                </div>
                <div class="admin-user-menu">
                    <button class="admin-profile-btn" id="profileToggle" aria-label="User Menu">
                        <div class="admin-avatar">
                            <i class="fa-regular fa-user"></i>
                        </div>
                    </button>
                    <div class="admin-dropdown-menu" id="profileMenu">
                        <a href="profile.php" class="dropdown-item">
                            <i class="fa-regular fa-user-circle"></i> My Profile
                        </a>
                        <a href="settings.php" class="dropdown-item">
                            <i class="fa-solid fa-gear"></i> Settings
                        </a>
                        <hr class="dropdown-divider">
                        <a href="../logout.php" class="dropdown-item logout-item">
                            <i class="fa-solid fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <nav class="admin-nav">
            <div class="nav-section">
                <h3 class="nav-section-title">Main</h3>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'dashboard.php') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h3 class="nav-section-title">Management</h3>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="manage_users.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'manage_users.php') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_services.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'manage_services.php') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-briefcase"></i>
                            <span>Services</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_bookings.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'manage_bookings.php') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Bookings</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h3 class="nav-section-title">Other</h3>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="../dashboard.php" class="nav-link" target="_blank">
                            <i class="fa-solid fa-globe"></i>
                            <span>View Website</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>

    <!-- Main Content Container -->
    <main class="admin-main">
