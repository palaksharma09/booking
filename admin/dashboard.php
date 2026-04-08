<?php
include 'auth.php';
include 'header.php';

// Fetch Dashboard Statistics
$stats = [];

// Total Users
$userSql = "SELECT COUNT(*) as count FROM users";
$userStmt = $conn->prepare($userSql);
$userStmt->execute();
$userResult = $userStmt->get_result();
$stats['total_users'] = $userResult->fetch_assoc()['count'];
$userStmt->close();

// Total Services
$serviceSql = "SELECT COUNT(*) as count FROM services";
$serviceStmt = $conn->prepare($serviceSql);
$serviceStmt->execute();
$serviceResult = $serviceStmt->get_result();
$stats['total_services'] = $serviceResult->fetch_assoc()['count'];
$serviceStmt->close();

// Total Bookings
$bookingSql = "SELECT COUNT(*) as count FROM bookings";
$bookingStmt = $conn->prepare($bookingSql);
$bookingStmt->execute();
$bookingResult = $bookingStmt->get_result();
$stats['total_bookings'] = $bookingResult->fetch_assoc()['count'];
$bookingStmt->close();

// Total Revenue
$revenueSql = "SELECT COALESCE(SUM(total_amount), 0) as total FROM bookings WHERE status IN ('confirmed', 'completed')";
$revenueStmt = $conn->prepare($revenueSql);
$revenueStmt->execute();
$revenueResult = $revenueStmt->get_result();
$stats['total_revenue'] = $revenueResult->fetch_assoc()['total'];
$revenueStmt->close();

// Booking Status Breakdown
$statusSql = "SELECT status, COUNT(*) as count FROM bookings GROUP BY status";
$statusStmt = $conn->prepare($statusSql);
$statusStmt->execute();
$statusResult = $statusStmt->get_result();
$statusBreakdown = [];
while ($row = $statusResult->fetch_assoc()) {
    $statusBreakdown[$row['status']] = $row['count'];
}
$statusStmt->close();

// Recent Bookings
$recentSql = "SELECT b.booking_id, b.booking_date, b.service_price, b.status,
                     s.name AS service_name, u.user_name, p.provider_name
              FROM bookings b
              INNER JOIN services s ON s.id = b.service_id
              INNER JOIN users u ON u.user_id = b.user_id
              INNER JOIN provider p ON p.provider_id = b.provider_id
              ORDER BY b.created_at DESC
              LIMIT 5";
$recentStmt = $conn->prepare($recentSql);
$recentStmt->execute();
$recentResult = $recentStmt->get_result();
$recentBookings = $recentResult->fetch_all(MYSQLI_ASSOC);
$recentStmt->close();
?>

<div class="admin-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div class="header-content">
            <h1>Dashboard</h1>
            <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>! Here's your business overview.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-card-users">
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>Total Users</h3>
                <p class="stat-value"><?php echo $stats['total_users']; ?></p>
                <span class="stat-label">Active Users</span>
            </div>
        </div>

        <div class="stat-card stat-card-services">
            <div class="stat-icon">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <div class="stat-content">
                <h3>Total Services</h3>
                <p class="stat-value"><?php echo $stats['total_services']; ?></p>
                <span class="stat-label">Available Services</span>
            </div>
        </div>

        <div class="stat-card stat-card-bookings">
            <div class="stat-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3>Total Bookings</h3>
                <p class="stat-value"><?php echo $stats['total_bookings']; ?></p>
                <span class="stat-label">All Time</span>
            </div>
        </div>

        <div class="stat-card stat-card-revenue">
            <div class="stat-icon">
                <i class="fa-solid fa-coins"></i>
            </div>
            <div class="stat-content">
                <h3>Total Revenue</h3>
                <p class="stat-value">₹<?php echo number_format((float)$stats['total_revenue'], 0); ?></p>
                <span class="stat-label">Confirmed & Completed</span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Booking Status Breakdown -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2>Booking Status Overview</h2>
            </div>
            <div class="card-body">
                <div class="status-breakdown">
                    <?php foreach (['confirmed', 'pending', 'completed', 'cancelled'] as $status): ?>
                        <div class="status-item">
                            <div class="status-label">
                                <span class="status-badge status-<?php echo htmlspecialchars($status); ?>">
                                    <?php echo ucfirst($status); ?>
                                </span>
                            </div>
                            <div class="status-count">
                                <?php echo intval($statusBreakdown[$status] ?? 0); ?> bookings
                            </div>
                            <div class="status-bar">
                                <div class="status-fill <?php echo htmlspecialchars($status); ?>" 
                                     style="width: <?php echo ($stats['total_bookings'] > 0) ? (($statusBreakdown[$status] ?? 0) / $stats['total_bookings'] * 100) : 0; ?>%">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2>Recent Bookings</h2>
                <a href="manage_bookings.php" class="card-link">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentBookings)): ?>
                    <div class="recent-bookings-list">
                        <?php foreach ($recentBookings as $booking): ?>
                            <div class="booking-item">
                                <div class="booking-info">
                                    <h4><?php echo htmlspecialchars($booking['service_name']); ?></h4>
                                    <p><?php echo htmlspecialchars($booking['user_name']); ?> → <?php echo htmlspecialchars($booking['provider_name']); ?></p>
                                </div>
                                <div class="booking-meta">
                                    <span class="status-badge status-<?php echo htmlspecialchars($booking['status']); ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                    <span class="booking-amount">₹<?php echo number_format((float)$booking['service_price'], 0); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">No bookings yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2>Quick Actions</h2>
        <div class="actions-grid">
            <a href="manage_users.php" class="action-btn">
                <i class="fa-solid fa-user-plus"></i>
                <span>Manage Users</span>
            </a>
            <a href="manage_services.php" class="action-btn">
                <i class="fa-solid fa-plus"></i>
                <span>Add Service</span>
            </a>
            <a href="manage_bookings.php" class="action-btn">
                <i class="fa-solid fa-list"></i>
                <span>View Bookings</span>
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
