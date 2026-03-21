<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once 'db_conn.php';

$userId = (int) $_SESSION['user_id'];
$bookings = [];

$sql = "SELECT b.booking_id, b.booking_date, b.booking_time, b.service_price, b.status,
               s.name AS service_name, s.icon AS service_icon, p.provider_name
        FROM bookings b
        INNER JOIN services s ON s.id = b.service_id
        INNER JOIN provider p ON p.provider_id = b.provider_id
        WHERE b.user_id = ?
        ORDER BY b.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

include 'header.php';
?>

<section class="bookings-header">
    <div class="bookings-header-container">
        <div class="bookings-header-content">
            <div class="bookings-header-badge">
                <span class="header-badge-icon"><i class="fa-solid fa-clipboard-list"></i></span>
                <span>Your Bookings</span>
            </div>
            <h1>My <span class="header-highlight">Bookings</span></h1>
            <p class="bookings-header-description">Track, manage, and review all your service appointments in one place.</p>
        </div>
        <div class="bookings-header-image">
            <img src="https://images.unsplash.com/photo-1556740714-a8395b3bf30f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                 alt="Happy Customer"
                 onerror="this.src='https://via.placeholder.com/400x300?text=My+Bookings'">
        </div>
    </div>
    <div class="header-decoration-1"></div>
    <div class="header-decoration-2"></div>
</section>

<section class="bookings-section">
    <div class="bookings-container">
        <?php if (empty($bookings)): ?>
            <div class="booking-form-card" style="max-width: 900px; margin: 0 auto;">
                <h2 class="booking-form-title">No bookings yet</h2>
                <p class="booking-form-subtitle">You have not booked any services yet. Explore services and make your first booking.</p>
                <a href="services.php" class="service-modern-btn">Explore Services</a>
            </div>
        <?php else: ?>
            <?php foreach ($bookings as $booking): ?>
                <?php $statusClass = 'status-' . strtolower($booking['status']); ?>
                <div class="booking-card">
                    <div class="booking-card-header">
                        <div class="booking-icon"><i class="<?php echo htmlspecialchars($booking['service_icon']); ?>"></i></div>
                        <div class="booking-title">
                            <h3><?php echo htmlspecialchars($booking['service_name']); ?></h3>
                            <span class="booking-status <?php echo htmlspecialchars($statusClass); ?>"><?php echo htmlspecialchars(ucfirst($booking['status'])); ?></span>
                        </div>
                    </div>

                    <div class="booking-details">
                        <div class="booking-detail-item">
                            <span class="detail-label">Provider:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($booking['provider_name']); ?></span>
                        </div>
                        <div class="booking-detail-item">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value"><?php echo htmlspecialchars(date('d F Y', strtotime($booking['booking_date']))); ?></span>
                        </div>
                        <div class="booking-detail-item">
                            <span class="detail-label">Time:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($booking['booking_time']); ?></span>
                        </div>
                        <div class="booking-detail-item">
                            <span class="detail-label">Price:</span>
                            <span class="detail-value price">&#8377;<?php echo number_format((float) $booking['service_price'], 0); ?></span>
                        </div>
                    </div>

                    <div class="booking-card-footer">
                        <a href="booking-details.php?id=<?php echo (int) $booking['booking_id']; ?>" class="booking-btn view-btn">View Details</a>
                        <a href="#" class="booking-btn cancel-btn disabled" onclick="return false;"><?php echo htmlspecialchars(ucfirst($booking['status'])); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>
