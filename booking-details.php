<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once 'db_conn.php';

$bookingId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$userId = (int) $_SESSION['user_id'];

$sql = "SELECT b.booking_id, b.full_name, b.phone, b.email, b.address, b.city, b.pincode, b.landmark,
               b.booking_date, b.booking_time, b.payment_method, b.special_instructions, b.total_amount,
               b.status, s.name AS service_name, c.slug AS category_slug, p.provider_name
        FROM bookings b
        INNER JOIN services s ON s.id = b.service_id
        INNER JOIN categories c ON c.id = s.category_id
        INNER JOIN provider p ON p.provider_id = b.provider_id
        WHERE b.booking_id = ? AND b.user_id = ?
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $bookingId, $userId);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$stmt->close();
$conn->close();

include 'header.php';

if (!$booking) {
    echo '<section class="booking-main-section"><div class="booking-form-card"><h2>Booking not found</h2><p>The requested booking could not be found.</p><p><a href="my-bookings.php" class="service-modern-btn">Back to My Bookings</a></p></div></section>';
    include 'footer.php';
    exit();
}
?>

<section class="booking-main-section">
    <div class="booking-container">
        <div class="booking-form-card">
            <?php if (isset($_GET['booking']) && $_GET['booking'] === 'success'): ?>
                <div class="success-message" style="margin-bottom: 24px;">
                    Booking confirmed successfully. Your reference ID is <strong>#<?php echo (int) $booking['booking_id']; ?></strong>.
                </div>
            <?php endif; ?>

            <h2 class="booking-form-title">Booking Details</h2>
            <p class="booking-form-subtitle">Review your appointment summary and contact information.</p>

            <div class="service-summary-card">
                <div class="summary-details">
                    <div class="summary-row"><span class="summary-label">Booking ID</span><span class="summary-value">#<?php echo (int) $booking['booking_id']; ?></span></div>
                    <div class="summary-row"><span class="summary-label">Service</span><span class="summary-value"><?php echo htmlspecialchars($booking['service_name']); ?></span></div>
                    <div class="summary-row"><span class="summary-label">Professional</span><span class="summary-value"><?php echo htmlspecialchars($booking['provider_name']); ?></span></div>
                    <div class="summary-row"><span class="summary-label">Status</span><span class="summary-value"><?php echo htmlspecialchars(ucfirst($booking['status'])); ?></span></div>
                    <div class="summary-row"><span class="summary-label">Date</span><span class="summary-value"><?php echo htmlspecialchars(date('d M Y', strtotime($booking['booking_date']))); ?></span></div>
                    <div class="summary-row"><span class="summary-label">Time</span><span class="summary-value"><?php echo htmlspecialchars($booking['booking_time']); ?></span></div>
                    <div class="summary-row"><span class="summary-label">Total</span><span class="summary-value price">&#8377;<?php echo number_format((float) $booking['total_amount'], 0); ?></span></div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-row"><span class="info-label">Customer</span><span class="info-value"><?php echo htmlspecialchars($booking['full_name']); ?></span></div>
                <div class="info-row"><span class="info-label">Phone</span><span class="info-value"><?php echo htmlspecialchars($booking['phone']); ?></span></div>
                <div class="info-row"><span class="info-label">Email</span><span class="info-value"><?php echo htmlspecialchars($booking['email']); ?></span></div>
                <div class="info-row"><span class="info-label">Address</span><span class="info-value"><?php echo htmlspecialchars(trim($booking['address'] . ', ' . $booking['city'] . ' ' . $booking['pincode'])); ?></span></div>
                <div class="info-row"><span class="info-label">Landmark</span><span class="info-value"><?php echo htmlspecialchars($booking['landmark'] ?: 'Not provided'); ?></span></div>
                <div class="info-row"><span class="info-label">Payment</span><span class="info-value"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $booking['payment_method']))); ?></span></div>
                <div class="info-row"><span class="info-label">Instructions</span><span class="info-value"><?php echo htmlspecialchars($booking['special_instructions'] ?: 'No special instructions added.'); ?></span></div>
            </div>

            <div class="form-actions">
                <a href="my-bookings.php" class="btn-cancel" style="text-align:center; text-decoration:none;">Back to My Bookings</a>
                <a href="services.php?category=<?php echo urlencode($booking['category_slug']); ?>" class="btn-submit" style="text-align:center; text-decoration:none;">Book Another Service</a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
