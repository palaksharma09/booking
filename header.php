<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiceHub - Professional Services at Your Doorstep</title>
    <link rel="stylesheet" href="CSS/commonfile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header class="main-header">
        <nav class="premium-navbar">
            <div class="nav-left">
                <a href="dashboard.php" class="brand-logo">ServiceHub</a>

                <div class="nav-links">
                    <a href="dashboard.php">Home</a>
                    <a href="my-bookings.php">My Bookings</a>
                    <a href="about-us.php">About Us</a>
                    <a href="contact-us.php">Contact Us</a>
                </div>
            </div>

            <div class="nav-right">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <span class="welcome-text">
                        Hi, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
                    </span>
                    <a href="my-profile.php" class="profile-icon-link" title="Profile" aria-label="My Profile">
                        <span class="profile-icon"><i class="fa-regular fa-user"></i></span>
                    </a>
                    <a href="logout.php" class="premium-btn">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="premium-btn">Login</a>
                    <a href="Registration.php" class="premium-btn" style="background: transparent; border: 1px solid var(--secondary-color);">Register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
